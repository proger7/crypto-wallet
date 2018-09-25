function btc_send() {
	alert("Loading form...");
}

function calculate_from_btc(value) {
	var btc_price = $("#btc_price").val();
	var sum = value * btc_price;
	var data = sum.toFixed(2);
		$("#amount_receive").val(data);
		$("#amount_receive2").val(data);
}

function calculate_from_btc2(value, btc_price) {
	var sum = value * btc_price;
	var data = sum.toFixed(2);
		$("#amount_receive").val(data);
		$("#amount_receive2").val(data);
}

function calculate_to_btc(value) {
	var btc_price = $("#btc_price").val();
	var sum = value / btc_price;
	var data = sum.toFixed(6);
	$("#amount_receive").val(data);
		$("#amount_receive2").val(data);
}

function calculate_to_btc2(value, btc_price) {
	var sum = value / btc_price;
	var data = sum.toFixed(6);
	$("#amount_receive").val(data);
		$("#amount_receive2").val(data);
}

function btc_get_payment_fields(gateway_id) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_get_payment_fields.php?gateway_id="+gateway_id;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "json",
		success: function (data) {
			$("#currency").html(data.currency);
			$("#btc_account_fields").html(data.fields);
			$("#btc_price").val(data.btcprice);
		}
	});
}

function btc_get_payment_data(gateway_id) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_get_payment_data.php?gateway_id="+gateway_id;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "json",
		success: function (data) {
			$("#currency").html(data.currency);
			$("#btc_account_fields").html(data.fields);
			$("#btc_price").val(data.btcprice);
		}
	});
}

function btc_generate_qr_code(address) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_forms.php?type=qr_code&address="+address;
	$.ajax({
		type: "POST",
		url: data_url,
		data: $("#btc_generate_qr_code").serialize(),
		dataType: "html",
		success: function (data) {
			$("#btc_qr_code").html(data);
		}
	});
}

function btc_calculate_fees(address) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_calculate_fees.php?address="+address;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$("#fee_text").html(data);
		}
	});
}

function btc_new_address() {
var url = $("#url").val();
	var data_url = url + "requests/btc_submit_form.php?type=new_address";
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$.notify({
				message: data
			});
			btc_refresh_addresses();
		}
	});
}

function btc_send_from_address(address_id) {
	btc_create_modal("send_from_address");
	var url = $("#url").val();
	var data_url = url + "requests/btc_forms.php?type=send_from_address&address_id="+address_id;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$("#html_send_from_address").html(data);
			$("#modal_send_from_address").modal("show");
		}
	});
}

function btc_send_bitcoins(address) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_submit_form.php?type=send_bitcoins&from_address="+address;
	$.ajax({
		type: "POST",
		url: data_url,
		data: $("#btc_from_send_bitcoins").serialize(),
		dataType: "json",
		success: function (data) {
			if(data.status == "success") {
				btc_refresh_addresses();
				$("#btc_send_from_address_results").html(data.msg);
				$("#btc_total").html(data.btc_total);
			} else {
				$("#btc_send_from_address_results").html(data.msg);
			}
		}
	});
}

function btc_receive_to_address(address_id) {
	btc_create_modal("receive_to_address");
	var url = $("#url").val();
	var data_url = url + "requests/btc_forms.php?type=receive_to_address&address_id="+address_id;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$("#html_receive_to_address").html(data);
			$("#modal_receive_to_address").modal("show");
		}
	});
}

function btc_archive_address(address_id) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_submit_form.php?type=archive_address&address_id="+address_id;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$.notify({
				message: data
			});
			btc_refresh_addresses();
		}
	});
}

function btc_unarchive_address(address_id) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_submit_form.php?type=unarchive_address&address_id="+address_id;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$.notify({
				message: data
			});
			btc_refresh_all_addresses();
		}
	});
}

function btc_submit_new_address() {
	var url = $("#url").val();
	var data_url = url + "requests/btc_submit_form.php?type=new_address";
	$.ajax({
		type: "POST",
		url: data_url,
		data: $("#form_new_address").serialize(),
		dataType: "json",
		success: function (data) {
			if(data.status == "success") {
				btc_refresh_addresses();
				$("#html_new_address_results").html(data.msg);
				$("#modal_new_address").delay(5000).modal("hide");
			} else {
				$("#html_new_address_results").html(data.msg);
			}
		}
	});
}

function btc_create_modal(type) {
	var url = $("#url").val();
	var data_url = url + "requests/btc_create_modal.php?type="+type;
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$("#btc_modals").html(data);
		}
	});
}

function btc_refresh_addresses() {
	var url = $("#url").val();
	var data_url = url + "requests/btc_refresh_addresses.php";
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$("#btc_addresses").html(data);
		}
	});
}

function btc_refresh_all_addresses() {
	var url = $("#url").val();
	var data_url = url + "requests/btc_refresh_all_addresses.php";
	$.ajax({
		type: "GET",
		url: data_url,
		dataType: "html",
		success: function (data) {
			$("#btc_addresses").html(data);
		}
	});
}

function btc_show_order_type_fields(val) {
	if (val == 'market') {
		$('#stop_price, #limit_price').hide();
	} else if (val == 'limit') {
		$('#limit_price').show();
		$('#stop_price').hide();
	} else if (val == 'stop') {
		$('#limit_price').hide();
		$('#stop_price').show();
	}
}