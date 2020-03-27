$(document).ready(function() {
	document.getElementById("projectOwner").onkeyup = function() {
		search();
	};
});

function search() {
	console.log(document.getElementById("projectOwner").innerHTML);
	$.ajax({
		type: "POST",
		url: "http://localhost/WebExportation/users/userList",
		data: {
			keyword: document.getElementById("projectOwner").innerHTML
		},
		dataType: "json",
		success: function(data) {
			let obj = JSON.stringify(data);
			console.log(data);
			autocomplete_results = document.getElementById("show_search_results");
			autocomplete_results.innerHTML = "";
			for (i = 0; i < data.length; i++) {
				autocomplete_results.innerHTML +=
					"<li onclick='myValue(this)' value='" +
					data[i].id +
					"'>" +
					data[i].name +
					"</li>";
			}
		}
	});
}

function myValue(e) {
	console.log(e.innerHTML);
	document.getElementById("projectOwner").innerHTML = e.innerHTML;
	document.getElementById("project.projectOwnerId").value = e.value;
	let ele = document.getElementById("show_search_results");
	let child = ele.lastElementChild;
	while (child) {
		ele.removeChild(child);
		child = ele.lastElementChild;
	}
}
