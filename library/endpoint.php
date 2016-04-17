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
        register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
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
		//$args['order']                = $request['order'];
		//$args['orderby']              = $request['orderby'];
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

		//$taxonomies = wp_list_filter( get_object_taxonomies( $postType, 'objects' ), array( 'show_in_rest' => true ) );
		//foreach ( $taxonomies as $taxonomy ) {
		//    $base = ! empty( $taxonomy->rest_base ) ? $taxonomy->rest_base : $taxonomy->name;

		//    if ( ! empty( $request[ $base ] ) ) {
		//        $query_args['tax_query'][] = array(
		//            'taxonomy'         => $taxonomy->name,
		//            'field'            => 'term_id',
		//            'terms'            => $request[ $base ],
		//            'include_children' => false,
		//        );
		//    }
		//}

		$posts_query = new WP_Query();
		$query_result = $posts_query->query( $query_args );

		$posts = array();
		foreach ( $query_result as $post ) {
			if ( ! $this->check_read_permission( $post ) ) {
				continue;
			}

			$data = $this->prepare_item_for_response( $post, $request );
			$posts[] = $this->prepare_response_for_collection( $data );
		}

		$page = (int) $query_args['paged'];
		$total_posts = $posts_query->found_posts;

		if ( $total_posts < 1 ) {
			// Out-of-bounds, run the query again without LIMIT for total count
			unset( $query_args['paged'] );
			$count_query = new WP_Query();
			$count_query->query( $query_args );
			$total_posts = $count_query->found_posts;
		}

		$max_pages = ceil( $total_posts / (int) $query_args['posts_per_page'] );

		$response = rest_ensure_response( $posts );
		$response->header( 'X-WP-Total', (int) $total_posts );
		$response->header( 'X-WP-TotalPages', (int) $max_pages );

		$request_params = $request->get_query_params();
		if ( ! empty( $request_params['filter'] ) ) {
			// Normalize the pagination params.
			unset( $request_params['filter']['posts_per_page'] );
			unset( $request_params['filter']['paged'] );
		}
		$base = add_query_arg( $request_params, rest_url( sprintf( '/%s/%s', $this->namespace, $this->rest_base ) ) );

		if ( $page > 1 ) {
			$prev_page = $page - 1;
			if ( $prev_page > $max_pages ) {
				$prev_page = $max_pages;
			}
			$prev_link = add_query_arg( 'page', $prev_page, $base );
			$response->link_header( 'prev', $prev_link );
		}
		if ( $max_pages > $page ) {
			$next_page = $page + 1;
			$next_link = add_query_arg( 'page', $next_page, $base );
			$response->link_header( 'next', $next_link );
		}

		return $response;
    }

    /**
	 * Get one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
    public function get_item( $request ) {
        //get parameters from request
        $params = $request->get_params();
        $item = array();//do a query, call another class, etc
        $data = $this->prepare_item_for_response( $item, $request );

        //return a response or error based on some conditional
        if ( 1 == 1 ) {
            return new WP_REST_Response( $data, 200 );
        }else{
            return new WP_Error( 'code', __( 'message', 'text-domain' ) );
        }
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
    public function prepare_item_for_response( $item, $request ) {
		$fields = array();
		foreach(get_fields($item->ID) as $key => $value) {
			if($key == "media") {
				$media = array();
				foreach($value as $mediaItem) {
					$media["type"] = $mediaItem["acf_fc_layout"];
					$media["description"] = $mediaItem["image_description"];
					if($mediaItem["acf_fc_layout"] == "picture") {
						$media["content"] = wp_get_attachment_image_src($mediaItem["image"], "full");
					}
					else {
						$media["content"] = $mediaItem["image"];
					}
				}
				$fields[$key] = $media;
			}
			elseif($key == "feature_image") {
				$fields[$key] = wp_get_attachment_image_src($value);
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

		//return $fields;
		$project = array();
		$project["id"] = $item->ID;
		$project["slug"] = $item->post_name;
		$project["createDate"] = $item->post_date;
		$project["name"] = $fields["display_name"];
		$project["description"] = $fields["description"];
		$project["featureImage"] = $fields["feature_image"];
		$project["media"] = (array)$fields["media"];
		$project["tags"] = $tags;
		return (object)$project;
    }

	///**
	// * Get the query params for collections
	// *
	// * @return array
	// */
	//public function get_collection_params() {
	//    return array(
	//        'page'                   => array(
	//            'description'        => 'Current page of the collection.',
	//            'type'               => 'integer',
	//            'default'            => 1,
	//            'sanitize_callback'  => 'absint',
	//        ),
	//        'per_page'               => array(
	//            'description'        => 'Maximum number of items to be returned in result set.',
	//            'type'               => 'integer',
	//            'default'            => 10,
	//            'sanitize_callback'  => 'absint',
	//        ),
	//        'search'                 => array(
	//            'description'        => 'Limit results to those matching a string.',
	//            'type'               => 'string',
	//            'sanitize_callback'  => 'sanitize_text_field',
	//        ),
	//    );
	//}
}

add_action('rest_api_init', function() {
	$controller = new AstralController('project');
	$controller->register_routes();
});

?>
