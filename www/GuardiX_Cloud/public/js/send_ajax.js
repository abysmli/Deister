//============================================================================
// 
// Author      : Li, Yuan
// File        : sendAjax.js
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 3.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     This script defined three callback functions for sending POST requests 
// by Ajax
//
//============================================================================

// sending post ajax request to backend
function sendAjax(mUrl, mData, callback) {
	$.ajax({
		url: mUrl,
		type: 'POST',
		timeout: 10000,
		data: mData,
		success: callback,
		error: function (xhr, ajaxOptions, thrownError) {
           	alert(xhr.status);
           	alert(xhr.responseText);
           	alert(thrownError);
       	}
	});
}