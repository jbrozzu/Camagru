
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
		console.log("An error occured! ");
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
	    	canvas.getContext('2d').drawImage(img, 180, 20, 100, 100);
	    }
	    else if (nb == 1) {
	    	canvas.getContext('2d').drawImage(img, 70, 150, 80, 80);
	    }
	    else if (nb == 2) {
	    	canvas.getContext('2d').drawImage(img, 30, 30, 120, 120);
	    }
	    else if (nb == 3) {
	    	canvas.getContext('2d').drawImage(img, 70, 150, 100, 100);
	    }
	    else if (nb == 4) {
	    	canvas.getContext('2d').drawImage(img, 100, 40, 190, 190);
	    }
	    else if (nb == 5) {
	    	canvas.getContext('2d').drawImage(img, 150, 160, 100, 50);
	    }
	    else if (nb == 6) {
	    	canvas.getContext('2d').drawImage(img, 0, 0, 400, 300);
	    }
	    else if (nb == 7) {
	    	canvas.getContext('2d').drawImage(img, 0, -50, 400, 500);
	    }
	    else if (nb == 8) {
	    	canvas.getContext('2d').drawImage(img, -50, -60, 500, 500);
	    }
	    else if (nb == 9) {
	    	canvas.getContext('2d').drawImage(img, 0, 100, 200, 200);
	    }
	    else if (nb == 10) {
	    	canvas.getContext('2d').drawImage(img, 230, 150, 200, 150);
	    }

		photo.setAttribute('src', canvas.toDataURL('image/png'));
	});

})();

function  getDataURL() {
  var dataURL = canvas.toDataURL();
  console.log(dataURL);
  document.getElementById('postpic').value = dataURL;
}