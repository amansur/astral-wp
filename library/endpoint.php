<?php

class AstralController extends WP_REST_Controller {

    /**
	 * Register the routes for the objects of the controller.
	 */
    public function register_routes() {
        $version = '1';
        $namespace = 'astral/v' . $version;
        $base = 'project';
        register_rest_route( $namespace, '/' . $base, array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_items' ),
                'args'            => array(

                ),
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/(?P<slug>[\w-]+)', array(
            array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'get_item' ),
                'args'            => array(
                    'context'          => array(
                        'default'      => 'view',
                    ),
                ),
            ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/schema', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'get_public_item_schema' ),
        ) );
    }

    /**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
    public function get_items( $request ) {
		$postType = 'project'; //$postType = $this->post_type;
		$args                         = array();
		//$args['meta_key']			  = 'display_name';
		$args['orderby']              = 'name';
		$args['order']                = 'ASC';		
		$args['posts_per_page']       = $request['per_page'] ? $request['per_page'] : -1;
		$args['post_type']			  = $postType;

		/**
		 * Filter the query arguments for a request.
		 *
		 * Enables adding extra arguments or setting defaults for a post
		 * collection request.
		 *
		 * @see https://developer.wordpress.org/reference/classes/wp_user_query/
		 *
		 * @param array           $args    Key value array of query var to query value.
		 * @param WP_REST_Request $request The request used.
		 */
		$args = apply_filters( "rest_{$postType}_query", $args, $request );
		$query_args = $this->prepare_items_query( $args, $request );
		$posts_query = new WP_Query();
		$query_result = $posts_query->query( $query_args );

		$posts = array();
		foreach ( $query_result as $post ) {
			if ( ! $this->check_read_permission( $post ) ) {
				continue;
			}

			$data = $this->prepare_items_for_response( $post, $request );
			$posts[] = $this->prepare_response_for_collection( $data );
		}

		$response = rest_ensure_response( $posts );
		return $response;
    }

    /**
	 * Get one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
    public function get_item( $request ) {
		$postType			= 'project';
		$args				= array();
		$args['name']			= $request['slug'];
		$args['post_type']	= $postType;

		$query_args = $this->prepare_items_query( $args, $request );
		$posts_query = new WP_Query();
		$query_result = $posts_query->query( $query_args );

		$item;
		foreach($query_result as $post) {
			$item = $this->prepare_item_for_response($post, $request);
		}

		$response = rest_ensure_response($item);

		return $response;
    }

	/**
	 * Determine the allowed query_vars for a get_items() response and
	 * prepare for WP_Query.
	 *
	 * @param array           $prepared_args
	 * @param WP_REST_Request $request
	 * @return array          $query_args
	 */
	protected function prepare_items_query( $prepared_args = array(), $request = null ) {

		$valid_vars = array_flip( $this->get_allowed_query_vars() );
		$query_args = array();
		foreach ( $valid_vars as $var => $index ) {
			if ( isset( $prepared_args[ $var ] ) ) {
				/**
				 * Filter the query_vars used in `get_items` for the constructed query.
				 *
				 * The dynamic portion of the hook name, $var, refers to the query_var key.
				 *
				 * @param mixed $prepared_args[ $var ] The query_var value.
				 *
				 */
				$query_args[ $var ] = apply_filters( "rest_query_var-{$var}", $prepared_args[ $var ] );
			}
		}

		if ( 'post' !== $this->post_type || ! isset( $query_args['ignore_sticky_posts'] ) ) {
			$query_args['ignore_sticky_posts'] = true;
		}

		if ( 'include' === $query_args['orderby'] ) {
			$query_args['orderby'] = 'post__in';
		}

		return $query_args;
	}

	/**
	 * Get all the WP Query vars that are allowed for the API request.
	 *
	 * @return array
	 */
	protected function get_allowed_query_vars() {
		global $wp;

		/**
		 * Filter the publicly allowed query vars.
		 *
		 * Allows adjusting of the default query vars that are made public.
		 *
		 * @param array  Array of allowed WP_Query query vars.
		 */
		$valid_vars = apply_filters( 'query_vars', $wp->public_query_vars );

		$post_type_obj = get_post_type_object( $this->post_type );
		if ( current_user_can( $post_type_obj->cap->edit_posts ) ) {
			/**
			 * Filter the allowed 'private' query vars for authorized users.
			 *
			 * If the user has the `edit_posts` capability, we also allow use of
			 * private query parameters, which are only undesirable on the
			 * frontend, but are safe for use in query strings.
			 *
			 * To disable anyway, use
			 * `add_filter( 'rest_private_query_vars', '__return_empty_array' );`
			 *
			 * @param array $private_query_vars Array of allowed query vars for authorized users.
			 * }
			 */
			$private = apply_filters( 'rest_private_query_vars', $wp->private_query_vars );
			$valid_vars = array_merge( $valid_vars, $private );
		}
		// Define our own in addition to WP's normal vars.
		$rest_valid = array(
			'author__in',
			'author__not_in',
			'ignore_sticky_posts',
			'menu_order',
			'offset',
			'post__in',
			'post__not_in',
			'post_parent',
			'post_parent__in',
			'post_parent__not_in',
			'posts_per_page',
			'date_query',
		);
		$valid_vars = array_merge( $valid_vars, $rest_valid );

		/**
		 * Filter allowed query vars for the REST API.
		 *
		 * This filter allows you to add or remove query vars from the final allowed
		 * list for all requests, including unauthenticated ones. To alter the
		 * vars for editors only, {@see rest_private_query_vars}.
		 *
		 * @param array {
		 *    Array of allowed WP_Query query vars.
		 *
		 *    @param string $allowed_query_var The query var to allow.
		 * }
		 */
		$valid_vars = apply_filters( 'rest_query_vars', $valid_vars );

		return $valid_vars;
	}

	/**
	 * Check if we can read a post.
	 *
	 * Correctly handles posts with the inherit status.
	 *
	 * @param object $post Post object.
	 * @return boolean Can we read it?
	 */
	public function check_read_permission( $post ) {
		if ( ! empty( $post->post_password ) && ! $this->check_update_permission( $post ) ) {
			return false;
		}

		$post_type = get_post_type_object( $post->post_type );
		if ( ! $this->check_is_post_type_allowed( $post_type ) ) {
			return false;
		}

		// Can we read the post?
		if ( 'publish' === $post->post_status || current_user_can( $post_type->cap->read_post, $post->ID ) ) {
			return true;
		}

		$post_status_obj = get_post_status_object( $post->post_status );
		if ( $post_status_obj && $post_status_obj->public ) {
			return true;
		}

		// Can we read the parent if we're inheriting?
		if ( 'inherit' === $post->post_status && $post->post_parent > 0 ) {
			$parent = get_post( $post->post_parent );
			return $this->check_read_permission( $parent );
		}

		// If we don't have a parent, but the status is set to inherit, assume
		// it's published (as per get_post_status()).
		if ( 'inherit' === $post->post_status ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if a given post type should be viewed or managed.
	 *
	 * @param object|string $post_type
	 * @return boolean Is post type allowed?
	 */
	protected function check_is_post_type_allowed( $post_type ) {
		if ( ! is_object( $post_type ) ) {
			$post_type = get_post_type_object( $post_type );
		}

		if ( ! empty( $post_type ) && ! empty( $post_type->show_in_rest ) ) {
			return true;
		}

		return false;
	}
    

    /**
	 * Prepare the item for the REST response
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
    public function prepare_items_for_response( $item, $request ) {
		$fields = array();
		foreach(get_fields($item->ID) as $key => $value) {
			if($key == "feature_image") {
				$fields[$key] = wp_get_attachment_image_src($value, 'astralweb-thumb-255');
			}
			else {
				$fields[$key] = $value;
			}
		}

		$tags = array();
		$terms = get_the_terms($item->ID, "project_tag");
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach(get_the_terms($item->ID, "project_tag") as $key => $value) {
				$tag			= array();
				$tag["id"]		= $value->term_id;
				$tag["name"]	= $value->name;
				array_push($tags, $tag);
			}
		}

		$project = array();
		$project["id"] = $item->ID;
		//$project["createDate"] = $item->post_date;
		//$project["description"] = $fields["description"];
		//$project["media"] = (array)$fields["media"];
		$project["slug"] = $item->post_name;
		$project["name"] = $fields["display_name"];
		$project["featureImage"] = $fields["feature_image"];
		$project["tags"] = $tags;
		return (object)$project;
    }

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
    public function prepare_item_for_response( $item, $request ) {
		//return $item;
		$fields = array();
		foreach(get_fields($item->ID) as $key => $value) {
		    if($key == "media") {
		        $mediaList = array();
		        foreach($value as $mediaItem) {
					$media = array();
		            $media["type"] = $mediaItem["acf_fc_layout"];
		            if($mediaItem["acf_fc_layout"] == "picture") {
						$imgSrc = wp_get_attachment_image_src($mediaItem["image"], "full");
						if(count($imgSrc) > 0) {
							$media["content"] = $imgSrc[0];
						}
		                
						$media["description"] = $mediaItem["image_description"];
						$media["halfWidth"] = $mediaItem["half-width"];
		            }
		            else {
		                $media["content"] = $mediaItem["video_url"];
						$media["description"] = $mediaItem["video_description"];
		            }
					array_push($mediaList, $media);
		        }
		        $fields[$key] = $mediaList;
		    }
		    else {
		        $fields[$key] = $value;
		    }
		}

		$tags = array();
		foreach(get_the_terms($item->ID, "project_tag") as $key => $value) {
		    $tag			= array();
		    $tag["id"]		= $value->term_id;
		    $tag["name"]	= $value->name;
		    array_push($tags, $tag);
		}

		//$project["createDate"] = $item->post_date;
		//$project["featureImage"] = $fields["feature_image"];
		$project = array();
		$project["id"] = $item->ID;
		$project["slug"] = $item->post_name;
		$project["name"] = $fields["display_name"];
		$project["description"] = $fields["description"];
		$project["media"] = (array)$fields["media"];
		$project["tags"] = $tags;
		return (object)$project;
    }
}

function astralRestApiInit() {
	$controller = new AstralController('project');
	$controller->register_routes();
}
add_action('rest_api_init', 'astralRestApiInit');

?>
