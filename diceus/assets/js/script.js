var intl_tel_default_setting={initialCountry:"auto",utilsScript:wpcf7_utils_url};jQuery(".wpcf7-intl-tel").each(function(){var t=jQuery(this),e={};void 0!=t.data("preferredcountries")&&""!=t.data("preferredcountries")&&(e.preferredCountries=t.data("preferredcountries").split("-")),t.intlTelInput(Object.assign({},intl_tel_default_setting,e));var n=t.parents("span")[0];t.parents("form").submit(function(){jQuery(n).children("input.wpcf7-intl-tel-full").val(t.intlTelInput("getNumber")),jQuery(n).children("input.wpcf7-intl-tel-country-name").val(t.intlTelInput("getSelectedCountryData").name),jQuery(n).children("input.wpcf7-intl-tel-country-code").val(t.intlTelInput("getSelectedCountryData").dialCode),jQuery(n).children("input.wpcf7-intl-tel-country-iso2").val(t.intlTelInput("getSelectedCountryData").iso2)})});