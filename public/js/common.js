
if (jQuery.fn.dataTable) {

    jQuery.fn.dataTableExt.oApi.fnReloadAjax = function (oSettings, sNewSource, fnCallback, bStandingRedraw)
    {
        // DataTables 1.10 compatibility - if 1.10 then `versionCheck` exists.
        // 1.10's API has ajax reloading built in, so we use those abilities
        // directly.
        if (jQuery.fn.dataTable.versionCheck) {
            var api = new jQuery.fn.dataTable.Api(oSettings);

            if (sNewSource) {
                api.ajax.url(sNewSource).load(fnCallback, !bStandingRedraw);
            } else {
                api.ajax.reload(fnCallback, !bStandingRedraw);
            }
            return;
        }

        if (sNewSource !== undefined && sNewSource !== null) {
            oSettings.sAjaxSource = sNewSource;
        }

        // Server-side processing should just call fnDraw
        if (oSettings.oFeatures.bServerSide) {
            this.fnDraw();
            return;
        }

        this.oApi._fnProcessingDisplay(oSettings, true);
        var that = this;
        var iStart = oSettings._iDisplayStart;
        var aData = [];

        this.oApi._fnServerParams(oSettings, aData);

        oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function (json) {
            /* Clear the old information from the table */
            that.oApi._fnClearTable(oSettings);

            /* Got the data - add it to the table */
            var aData = (oSettings.sAjaxDataProp !== "") ?
                    that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

            for (var i = 0; i < aData.length; i++)
            {
                that.oApi._fnAddData(oSettings, aData[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

            that.fnDraw();

            if (bStandingRedraw === true)
            {
                oSettings._iDisplayStart = iStart;
                that.oApi._fnCalculateEnd(oSettings);
                that.fnDraw(false);
            }

            that.oApi._fnProcessingDisplay(oSettings, false);

            /* Callback user function - for event handlers etc */
            if (typeof fnCallback == 'function' && fnCallback !== null)
            {
                fnCallback(oSettings);
            }
        }, oSettings);
    };
}


function commonStatusMessage(data, indexUrl) {
    if (data.status == 'success') { //0
        //toastr.success(data.message);
        //KTBootstrapNotify('success', data.message);
        alert('success '+data.message);
        if (indexUrl) {
            window.location.href = indexUrl;
        }
        return true;
    } else if (data.status == 'error') { //1
        // toastr.error(data.message); 
        $.each(data.errors, function (i) {
            $('#' + i).parent().find('.invalid-feedback').remove();
            $.each(data.errors[i], function (key, val) {
                $('#' + i).addClass('is-invalid');
                $('#' + i).parent().append('<div class="invalid-feedback" for="' + i + '">' + val + '</div>');
            });
        });

        //toastr.error(data.message)
        alert('danger '+data.message);
    } else if (data.status == 'exist') { //2
        //toastr.warning(data.message);
        //KTBootstrapNotify('info', data.message);
        alert('warning '+data.message);
    }
}



function showError(error, element)
{
    if (element.is(":radio")) {
        error.insertAfter(element.parent().parent());
        error.removeClass('valid-feedback').addClass('invalid-feedback');
        element.removeClass('is-valid').addClass('is-invalid');
    } else { // This is the default behavior of the script
        if (element.attr('name') == "mobile" || element.attr('name') == "phone" || element.attr('type') == 'date' || element.attr('type') == 'email') {
            error.insertAfter(element);
            error.removeClass('valid-feedback').addClass('invalid-feedback');
            element.removeClass('is-valid').addClass('is-invalid');
        } else {
            error.insertAfter(element);
            error.removeClass('valid-feedback').addClass('invalid-feedback');
            element.removeClass('is-valid').addClass('is-invalid');
        }
    }
}