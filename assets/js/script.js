$(document).ready(function () {
	let selectedFile;
	const baseurl = $("#fileUpload").data("url");
	$("#fileUpload").on("change", function (event) {
		selectedFile = event.target.files[0];
		$("#fileUpLabel").html(selectedFile.name);
	});

	$("#upload").on("click", function () {
		if (selectedFile) {
			const fileReader = new FileReader();
			fileReader.readAsBinaryString(selectedFile);
			fileReader.onload = function (event) {
				let data = event.target.result;

				let wb = XLSX.read(data, { type: "binary" });

				wb.SheetNames.forEach((sheet) => {
					let rowObject = XLSX.utils.sheet_to_row_object_array(
						wb.Sheets[sheet]
					);
					$.ajax({
						url: baseurl + "jurnal/uploadKode",
						type: "POST",
						data: {
							kode: JSON.stringify(rowObject),
						},
						success: function (result) {
							document.location.href = baseurl + "jurnal/Kode_akun";
							console.log(result);
						},
					});
				});
			};
		}
	});
});
