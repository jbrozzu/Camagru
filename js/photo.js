
(function() {
	var video = document.getElementById('video'),
		canvas = document.getElementById('canvas'),
		context = canvas.getContext('2d'),
		photo = document.getElementById('photo'),
		vendorURL = window.URL || window.webkitURL;

	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia;

	navigator.getMedia({
		video: true,
		audio: false
	}, function(stream) {
		video.src = vendorURL.createObjectURL(stream);
		video.play();
	}, function(error) {
		console.log("An error occured! " + err);
	});

	document.getElementById('capture').addEventListener('click', function() {
		context.drawImage(video, 0, 0, 400, 300);

		var radios = document.getElementsByName('groupe_png');
	    var img;
	    for (var i = 0; i < radios.length; i++) {
	      	if (radios[i].checked) {
	        	img = document.getElementById(radios[i].value);
	        	var nb = i;
	        }
	    }
	    if (nb == 0) {
	    	canvas.getContext('2d').drawImage(img, 100, 100, 100, 100);
	    }
	    else {
	    	canvas.getContext('2d').drawImage(img, 30, 30, 100, 100);
	    }

		photo.setAttribute('src', canvas.toDataURL('image/png'));
	});

})();

function  getDataURL() {
  var dataURL = canvas.toDataURL();
  console.log(dataURL);
  document.getElementById('postpic').value = dataURL;
}