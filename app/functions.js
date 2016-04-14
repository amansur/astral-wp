function SplitArrayIntoN(array, n) {
	var i,j;
	var result = [];
	var chunk = Math.ceil(array.length / n);
	var smallChunk = Math.floor(array.length / n);
	for(i = 0, j = array.length; i < j; i+=chunk) {
		if (i != 0) chunk = smallChunk;
		result.push(array.slice(i, i + chunk));
		//i += chunk;
	}

	return result;
};