
        var checkFlag = false;
var suburbs = [
    "3000",
    "3001",
    "3002",
    "3003",
    "3005",
    "3006",
    "3008",
    "3010",
    "3011",
    "3012",
    "3013",
    "3015",
    "3016",
    "3018",
    "3019",
    "3020",
    "3021",
    "3022",
    "3023",
    "3024",
    "3025",
    "3026",
    "3028",
    "3029",
    "3030",
    "3031",
    "3032",
    "3033",
    "3034",
    "3036",
    "3037",
    "3038",
    "3039",
    "3040",
    "3041",
    "3042",
    "3043",
    "3044",
    "3045",
    "3046",
    "3047",
    "3048",
    "3049",
    "3050",
    "3051",
    "3052",
    "3053",
    "3054",
    "3055",
    "3056",
    "3057",
    "3058",
    "3059",
    "3060",
    "3061",
    "3062",
    "3063",
    "3064",
    "3065",
    "3066",
    "3067",
    "3068",
    "3070",
    "3071",
    "3072",
    "3073",
    "3074",
    "3075",
    "3076",
    "3078",
    "3079",
    "3081",
    "3082",
    "3083",
    "3084",
    "3085",
    "3087",
    "3088",
    "3089",
    "3090",
    "3091",
    "3093",
    "3094",
    "3095",
    "3096",
    "3097",
    "3099",
    "3101",
    "3102",
    "3103",
    "3104",
    "3105",
    "3106",
    "3107",
    "3108",
    "3109",
    "3110",
    "3111",
    "3113",
    "3114",
    "3115",
    "3116",
    "3121",
    "3122",
    "3123",
    "3124",
    "3125",
    "3126",
    "3127",
    "3128",
    "3129",
    "3130",
    "3131",
    "3132",
    "3133",
    "3134",
    "3135",
    "3136",
    "3137",
    "3138",
    "3139",
    "3140",
    "3141",
    "3142",
    "3143",
    "3144",
    "3145",
    "3146",
    "3147",
    "3148",
    "3149",
    "3150",
    "3151",
    "3152",
    "3153",
    "3154",
    "3155",
    "3156",
    "3158",
    "3159",
    "3160",
    "3161",
    "3162",
    "3163",
    "3164",
    "3165",
    "3166",
    "3167",
    "3168",
    "3169",
    "3170",
    "3171",
    "3172",
    "3173",
    "3174",
    "3175",
    "3176",
    "3177",
    "3178",
    "3179",
    "3180",
    "3181",
    "3182",
    "3183",
    "3184",
    "3185",
    "3186",
    "3187",
    "3188",
    "3189",
    "3190",
    "3191",
    "3192",
    "3193",
    "3194",
    "3195",
    "3196",
    "3197",
    "3198",
    "3199",
    "3200",
    "3201",
    "3202",
    "3204",
    "3205",
    "3206",
    "3207",
    "3335",
    "3337",
    "3427",
    "3428",
    "3429",
    "3752",
    "3765",
    "3766",
    "3767",
    "3770",
    "3775",
    "3777",
    "3781",
    "3782",
    "3786",
    "3787",
    "3788",
    "3789",
    "3791",
    "3792",
    "3793",
    "3795",
    "3796",
    "3802",
    "3803",
    "3804",
    "3805",
    "3806",
    "3807",
    "3808",
    "3809",
    "3810",
    "3910",
    "3911",
    "3912",
    "3913",
    "3915",
    "3916",
    "3918",
    "3919",
    "3920",
    "3926",
    "3927",
    "3928",
    "3929",
    "3930",
    "3931",
    "3933",
    "3934",
    "3936",
    "3937",
    "3938",
    "3939",
    "3940",
    "3941",
    "3942",
    "3943",
    "3944",
    "3975",
    "3976",
    "3977",
    "8001",
    "8002",
    "8003",
    "8004",
    "8005",
    "8006",
    "8007",
    "8008",
    "8009",
    "8010",
    "3004",
    "3027"
];



function validateAddress()
{
    var address = $("#suburb").val();
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address': address}, function (results, status) {
        $("#slectedCity").val("");
        if (status == google.maps.GeocoderStatus.OK) {
            var items=results[0].address_components;
            var isVic=false;
            for(var i=0;i<items.length;i++)
            {
                if(items[i].types[0]=="administrative_area_level_1")
                {
                   if( items[i].long_name=="Victoria")
                   {
                       isVic=true;
                   }
                }
                if(items[i].types[0]=="postal_code")
                {
                    $("#slectedCity").val(items[i].long_name);
                }
            }
            if(!isVic && $("#slectedCity").val()!="")
            {
                $("#slectedCity").val("notVic");
            }
        }
        $("#sub").trigger("click");
    });
}

function validateForm(theForm) {
    var input = document.forms["input"]["suburb"].value;
    var searchType = $("#searchType").val();
    if (searchType == "sbs")
    {
        if ((input == null || input == "") && searchType == "sbs") {
            alert("suburb input must be filled out");
            return false;
        }
        var selectedCity = $("#slectedCity").val();
        if($("#slectedCity").val()=="")
        {
            alert("The input is not valid, it should be either an ADDRESS, SUBURB or POSTCODE within Melbourne Region");
            return false;
        }
        else if ($.inArray(selectedCity,suburbs)==-1)
        {
            alert("The input should be ONLY within Melbourne");
            return false;
        }
    } else
    {
        var checkCR = document.getElementById("CrimeRate");
        var checkPD = document.getElementById("PopulationDensity");
        var checkPR = document.getElementById("Price");
        if (checkCR.checked || checkPD.checked || checkPR.checked) {
            checkFlag = true;
        }
        if (checkFlag == false) {
            alert("please choose at least one environment feature");
            return false;
        }
    }
}
