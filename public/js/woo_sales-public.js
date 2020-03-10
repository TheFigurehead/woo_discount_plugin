document.addEventListener('DOMContentLoaded', function(){

	if( ajax_object.show_popup != false ){

		function onMouseOut(event) {
			// If the mouse is near the top of the window, show the popup
			if (event.clientY < 50) {
				// Remove this event listener
				document.removeEventListener("mouseout", onMouseOut);
			
				// Show the popup
				document.getElementById("woo_addon_popup").style.display = "block";
			}
		}
	
		document.addEventListener("mouseout", onMouseOut);

		document.getElementById('woo_addon_popup__sure').addEventListener("click", function(){

			var request = new XMLHttpRequest();
	
			request.open('POST', ajax_object.ajax_url, true);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			
			request.onload = function () {
				if (this.status >= 200 && this.status < 400) {
					alert('Enjoy your discount!');
				} else {
					console.log(this.response);
				}
			};
			request.onerror = function() {
			};

			request.send('action=get_staying_discount');

			document.getElementById("woo_addon_popup").style.display = "none";

		});

		document.getElementById('woo_addon_popup__refuse').addEventListener("click", function(){

			var request = new XMLHttpRequest();
	
			request.open('POST', ajax_object.ajax_url, true);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');

			request.onload = function () {
				if (this.status >= 200 && this.status < 400) {
					// alert('Enjoy your discount!');
				} else {
					console.log(this.response);
				}
			};
			request.onerror = function() {
			};

			request.send('action=refuse_staying_discount');

			document.getElementById("woo_addon_popup").style.display = "none";

		});

	}

	if(document.querySelector('.woo_addon_close')){
		document.querySelector('.woo_addon_close').addEventListener('click', function(e){
			e.target.parentElement.style.display = "none";
		});
	}
	

});