function SplitArrayIntoN(array, n) {
	var i,j;
	var result = [];
	var chunk = Math.ceil(array.length / n);
	for(i = 0, j = array.length; i < j; i += chunk) {
		result.push(array.slice(i, i + chunk));
	}

	return result;
};