var mapNumbers = {
    0 : [2, 1, "ноль"],
    1 : [0, 2, "один", "одна"],
    2 : [1, 2, "два", "две"],
    3 : [1, 1, "три"],
    4 : [1, 1, "четыре"],
    5 : [2, 1, "пять"],
    6 : [2, 1, "шесть"],
    7 : [2, 1, "семь"],
    8 : [2, 1, "восемь"],
    9 : [2, 1, "девять"],
    10 : [2, 1, "десять"],
    11 : [2, 1, "одиннадцать"],
    12 : [2, 1, "двенадцать"],
    13 : [2, 1, "тринадцать"],
    14 : [2, 1, "четырнадцать"],
    15 : [2, 1, "пятнадцать"],
    16 : [2, 1, "шестнадцать"],
    17 : [2, 1, "семнадцать"],
    18 : [2, 1, "восемнадцать"],
    19 : [2, 1, "девятнадцать"],
    20 : [2, 1, "двадцать"],
    30 : [2, 1, "тридцать"],
    40 : [2, 1, "сорок"],
    50 : [2, 1, "пятьдесят"],
    60 : [2, 1, "шестьдесят"],
    70 : [2, 1, "семьдесят"],
    80 : [2, 1, "восемьдесят"],
    90 : [2, 1, "девяносто"],
    100 : [2, 1, "сто"],
    200 : [2, 1, "двести"],
    300 : [2, 1, "триста"],
    400 : [2, 1, "четыреста"],
    500 : [2, 1, "пятьсот"],
    600 : [2, 1, "шестьсот"],
    700 : [2, 1, "семьсот"],
    800 : [2, 1, "восемьсот"],
    900 : [2, 1, "девятьсот"]
};

var mapOrders = [
    { _Gender : true, _arrStates : ["рубль", "рубля", "рублей"] },
    { _Gender : false, _arrStates : ["тысяча", "тысячи", "тысяч"] },
    { _Gender : true, _arrStates : ["миллион", "миллиона", "миллионов"] },
    { _Gender : true, _arrStates : ["миллиард", "миллиарда", "миллиардов"] },
    { _Gender : true, _arrStates : ["триллион", "триллиона", "триллионов"] }
];

var objKop = { _Gender : false, _arrStates : ["копейка", "копейки", "копеек"] };

function Value(dVal, bGender) {
    var xVal = mapNumbers[dVal];
    if (xVal[1] == 1) {
        return xVal[2];
    } else {
        return xVal[2 + (bGender ? 0 : 1)];
    }
}

function From0To999(fValue, oObjDesc, fnAddNum, fnAddDesc)
{
    var nCurrState = 2;
    if (Math.floor(fValue/100) > 0) {
        var fCurr = Math.floor(fValue/100)*100;
        fnAddNum(Value(fCurr, oObjDesc._Gender));
        nCurrState = mapNumbers[fCurr][0];
        fValue -= fCurr;
    }

    if (fValue < 20) {
        if (Math.floor(fValue) > 0) {
            fnAddNum(Value(fValue, oObjDesc._Gender));
            nCurrState = mapNumbers[fValue][0];
        }
    } else {
        var fCurr = Math.floor(fValue/10)*10;
        fnAddNum(Value(fCurr, oObjDesc._Gender));
        nCurrState = mapNumbers[fCurr][0];
        fValue -= fCurr;

        if (Math.floor(fValue) > 0) {
            fnAddNum(Value(fValue, oObjDesc._Gender));
            nCurrState = mapNumbers[fValue][0];
        }
    }

    fnAddDesc(oObjDesc._arrStates[nCurrState]);
}

function FloatToSamplesInWordsRus(fAmount)
{
    var fInt = Math.floor(fAmount + 0.005);
    var fDec = Math.floor(((fAmount - fInt) * 100) + 0.5);

    var arrRet = [];
    var iOrder = 0;
    var arrThousands = [];
    for (; fInt > 0.9999; fInt/=1000) {
        arrThousands.push(Math.floor(fInt % 1000));
    }
    if (arrThousands.length == 0) {
        arrThousands.push(0);
    }

    function PushToRes(strVal) {
        arrRet.push(strVal);
    }

    for (var iSouth = arrThousands.length-1; iSouth >= 0; --iSouth) {
        if (arrThousands[iSouth] == 0) {
            continue;
        }
        From0To999(arrThousands[iSouth], mapOrders[iSouth], PushToRes, PushToRes);
    }

    if (arrThousands[0] == 0) {
        //  Handle zero amount
        if (arrThousands.length == 1) {
            PushToRes(Value(0, mapOrders[0]._Gender));
        }

        var nCurrState = 2;
        PushToRes(mapOrders[0]._arrStates[nCurrState]);
    }

    if (arrRet.length > 0) {
        // Capitalize first letter
        arrRet[0] = arrRet[0].match(/^(.)/)[1].toLocaleUpperCase() + arrRet[0].match(/^.(.*)$/)[1];
    }

    arrRet.push((fDec < 10) ? ("0" + fDec) : ("" + fDec));
    From0To999(fDec, objKop, function() {}, PushToRes);

    return arrRet.join(" ");
}

function roleChanging(self)
{
	var role = $(self).find("option:selected").val();
	if (role == 6) // If role is Agent
	{
		$('.user-add select[name=tariff], .user-edit select[name=tariff]').prop('disabled', false);
	}
	else
	{
		$('.user-add select[name=tariff], .user-edit select[name=tariff]').prop('disabled', true).find('option[value=]').prop('selected', true);
	}
	$('#subordinated_to').prop('disabled', true);
	$.ajax({
		'url': '/accounts/ajaxPrivilegedUsers/' + role,
		'data': {
			't': (new Date()).getTime(),
		},
		'dataType': 'json',
		'success': function (result)
			{
				if (result && result.success)
				{
					var sto = $('#subordinated_to select[name=subordinated_to\\[\\]]');
					sto.find('option').prop('disabled', true);
					for(var i=result.users.length-1; i>=0; i--)
					{
						var uid = result.users[i].id;
						sto.find('option[role='+ result.users[i].role_id +']').prop('disabled', false);
					}
				}
				else
				{
					alert("Произошла ошибка запроса");
				}
				$('#subordinated_to').prop('disabled', false);
			},
		'error': function ()
			{
				alert('Произошла ошибка при загрузке доступных ролей');
				$('#subordinated_to').prop('disabled', false);
			}
	});
	return true;
}


$(document).ready(function(){
	//alert($('select[name=role]').change());
	$('#subordinated_to select[name=subordinated_to\\[\\]]')
		.find('option')
			.prop('disabled', true)
		.end()
		.find('option:selected')
			.prop('disabled', false)
		.end();
	$('select[name=role]').change();
	
    //модалка для входа в систему
	if ($('#loginModal').length > 0)
	{
    	$('#loginModal').modal("show");
	}
    // все тултипы в системе
    $("body").on("mouseenter","*[data-toggle=tooltip]",function(){
        $(this).tooltip('show');
    });
    $("body").on("mouseleave","*[data-toggle=tooltip]",function(){
        $(this).tooltip('hide');
    });

// добавление договора ДМС
    $("body").on("click", "input[type=checkbox][name=insurFace]", function(){
        if($(this).attr("checked")=="checked"){
            $("#insurFace *").show();
            $(this).removeAttr("checked");
        }else{
            $("#insurFace *").hide();
            $(this).attr("checked","checked");
        }
    });
    $("body").on("click", "input[type=checkbox][name=moneyFace]", function(){
        if($(this).attr("checked")=="checked"){
            $("#vigFace *").show();
            $(this).removeAttr("checked");
        }else{
            $("#vigFace *").hide();
            $(this).attr("checked","checked");
        }
    });
    $("#formAddDogDms input[name=start_insur],#formAddDogDms input[name=end_insur]").datepicker({format:"dd/mm/yyyy", weekStart:1, viewMode:1});
    $("#formAddDogDms input[name^=dateRozh],#formAddDogDms input[name^=pass_date]").datepicker({format:"dd/mm/yyyy", weekStart:1, viewMode:2});
 // добавление договора финрисков

    $("#formAddDogFinR input[name=dateb]").datepicker({format:"dd/mm/yyyy", weekStart:1, viewMode:2});
    $("#formAddDogFinR input[name=summa]").on("keyup",this,function(){
        if($("#formAddDogFinR input[name=summa]").val()===''){
            $("#formAddDogFinR input[name=summa_pro]").val('');
            $("#formAddDogFinR input[name=premiya]").val('');
            $("#formAddDogFinR input[name=premiya_pro]").val('');

        }else{
            $("#formAddDogFinR input[name=summa_pro]").val(FloatToSamplesInWordsRus(parseFloat($("#formAddDogFinR input[name=summa]").val())));
            var tar = ($("#formAddDogFinR select[name=tariff]").val()*1)/100;
            var prem = parseFloat($("#formAddDogFinR input[name=summa]").val())*tar;
            prem = prem.toFixed(2);
            $("#formAddDogFinR input[name=premiya]").val(prem);
            $("#formAddDogFinR input[name=premiya_pro]").val(FloatToSamplesInWordsRus(parseFloat(prem)));
        }
    });
    $("#formAddDogFinR select[name=tariff]").on("change",this,function(){
        if($("#formAddDogFinR input[name=summa]").val()===''){
            $("#formAddDogFinR input[name=summa_pro]").val('');
            $("#formAddDogFinR input[name=premiya]").val('');
            $("#formAddDogFinR input[name=premiya_pro]").val('');

        }else{
            $("#formAddDogFinR input[name=summa_pro]").val(FloatToSamplesInWordsRus(parseFloat($("#formAddDogFinR input[name=summa]").val())));
            var tar = ($("#formAddDogFinR select[name=tariff]").val()*1)/100;
            var prem = parseFloat($("#formAddDogFinR input[name=summa]").val())*tar;
            prem = prem.toFixed(2);
            $("#formAddDogFinR input[name=premiya]").val(prem);
            $("#formAddDogFinR input[name=premiya_pro]").val(FloatToSamplesInWordsRus(parseFloat(prem)));
        }
    })
    $("#formAddDogFinR input[name=start_insur],#formAddDogFinR input[name=end_insur]").datepicker({format:"dd/mm/yyyy", weekStart:1, viewMode:1});
});
