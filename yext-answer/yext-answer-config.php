<?php
$servername = "localhost:3306";
$username = "mylsinternadmin";
$password = "Dv2l3@u9";
$dbname = "mylsintern";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            margin: 0px;
			background-color: #ECF0F1;
			font-family: Helvetica, sans-serif;
        }

        #builder-form {
            grid-column-start: 1;
            grid-column-end: 5;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        #builder-result {
            grid-column-start: 1;
            grid-column-end: 3;
        }

        #builder-form-lang {
            grid-column-start: 1;
            grid-column-end: 3;
            display: inline-block;
        }

        #builder-form-twoway {
            grid-column-start: 1;
            grid-column-end: 2;
        }

        #builder-form-oneway {
            grid-column-start: 2;
            grid-column-end: 3;
        }

        #builder-form-lang h1, #builder-form-twoway>button, #builder-form-oneway>button,#builder-form-twoway p, #builder-form-oneway p{
            margin-left: 10px;
        }

        #builder-form-lang>div{
            margin-left: 5px;
        }

        #popup {
            background-color: #00000022;
            width: 100vw;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        #popup-lang {
            background-color: #ffffff;
            width: 30vw;
            height: auto;
            padding: 20px;
            margin: 200px 0px 0px 35vw;
            display: grid;
            grid-template-columns: auto 40px;
        }
		
		#popup-api {
            background-color: #ffffff;
            width: 30vw;
            height: auto;
            padding: 20px;
            margin: 200px 0px 0px 35vw;
            display: grid;
            grid-template-columns: auto 40px;
        }

        .displaynon {
            display: none!important;
        }

        #popup-lang-list {
            display: grid;
            grid-template-columns: 100px auto;
        }

        .synonymSetSet>div {
            display: grid;
            grid-template-columns: auto 40px;
            padding: 10px 5px;
        }

        .synonymSetSet>div {
            background-color: #dadada;
        }

        .synonymSetSet>div>div {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .synonymSetSet>div:nth-child(even) {
            background-color: #ffffff;
        }

        .synonymSetSet>div>div>input {
            flex-grow: 1;
        }

        button {
            border: none;
            background-color: #008000;
            padding: 2px 10px;
            margin: 5px;
            font-size: 20px;
            border-radius: 50px;
        }

        button:hover {
            background-color: #00be00;
        }

        input {
            background-color: unset;
            border: none;
            font-size: 20px;
        }

        .synonymWaySetSet>div {
            background-color: #dadada;
            padding: 10px 5px;
        }

        .synonymWaySetSet>div:nth-child(even) {
            background-color: #ffffff;
        }

        .synonymWaySetSet>div {
            display: grid;
            grid-template-columns: auto 40px;
        }

        .synonymWaySetSet>div>div {
            grid-column: 1 / 3;
            display: flex;
            flex-wrap: wrap;
        }

        .synonymWaySetSet>div>div>input {
            flex-grow: 1;
        }

        .tags-input-wrapper {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc
        }

        .tags-input-wrapper input {
            border: none;
            background: transparent;
            outline: none;
            width: 150px;
        }

        .tags-input-wrapper .tag {
            display: inline-block;
            background-color: #009432;
            color: white;
            border-radius: 40px;
            padding: 0px 3px 0px 7px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input-wrapper .tag a {
            margin: 0 7px 3px;
            display: inline-block;
            cursor: pointer;
        }

        textarea {
            resize: none;
            overflow: hidden;
            min-height: 50px;
            border: none;
            margin-left: 100px;
			margin-top: 50px;
        }
        textarea:focus-visible {
            outline: none;
        }
        input:focus-visible {
            outline: none;
        }

        #builder-api input{
            border: 1px solid black;
        }

        #builder-api select{
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div id="builder-form">
        <div id="builder-form-lang">
            <h1>Languages</h1>
            <div id="builder-api">
                <select id="selectApi">
					<option value="-">Choos Api</option>
					<?php
					$sql = "SELECT * FROM `yext-answer-api`";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					  while($row = $result->fetch_assoc()) {
						echo '<option value="' . $row["string_apikey"] . '" ';
						  if ($_GET['api'] == $row["string_apikey"]) {
							  echo 'selected';
						  }
						echo '>' . $row["string_name"] . '</option>';
					  }
					}
					?>
					<option value="newapi">+ Add new APIkey</option>
                </select>
                <select id="selectBranch">
                    <option value="-">< Add AnswerAPI Key</option>
                </select>
            </div>
            <br>
            <div id="language-buttons"></div>
            <div><button onclick="openLangpopup()">Edit Language</button></div>
        </div>
        <div id="builder-form-twoway" class="displaynon">
            <p>Synonyms Set</p>
            <div class="synonymSetSet"></div>
            <button onclick="addNewSynonym()">+</button>
        </div>
        <div id="builder-form-oneway" class="displaynon">
            <p>One Way Synonyms</p>
            <div class="synonymWaySetSet">
            </div>
            <button onclick="addNewWaySynonym()">+</button>
        </div>
    </div>
    <textarea oninput="auto_grow()" id="builder-result">
        Use the power of the form
    </textarea>
	<div>
		<button onclick="getYextBranches()">Reload</button>
		<button onclick="savetoYext()">Save to Yext</button>
	</div>
    <div id="popup" class="displaynon">
        <div id="popup-lang" class="popup displaynon">
            <div>
                <select name="addLanguage">
                    <option value="de">Deutsch</option>
                    <option value="fr">Français</option>
                    <option value="en">English</option>
                    <option value="it">Italiano</option>
                </select>
                <button onclick="addLanguage()">Add Lanugage</button>
            </div>
            <button onclick="closePopup()">X</button>
            <div id="popup-lang-list">

            </div>
        </div>
		<div id="popup-api" class="popup displaynon">
            <div>
				
            </div>
            <button onclick="reload()">X</button>
			<div>
				<p>Name des Kunden</p>
				<input id="apikd" type="text">
				<p>API-Key</p>
				<input id="apikey" type="text">
                <button onclick="addApi()">Add API</button>
				<br><br>
				<?php
				$sql = "SELECT * FROM `yext-answer-api`";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo '<p>' . $row["string_name"] . ' | ' . $row["string_apikey"] . '<button onclick="rmApi(\''. $row["string_apikey"] .'\')">Remove API</button></p>';
					}
				}
				?>
			</div>
        </div>
    </div>

        

</body>

<script>
    let config = "";

    let json = {};

    //json = { "de": { "querySuggestions": { "popularQueriesBlacklistedTerms": [], "universalPrompts": ["Wo ist der Shop von Evard?", "Wie kann ich mit Evard Kontakt aufnehmen?"], "verticalPrompts": {} }, "synonyms": { "normalization": [], "oneWay": [{ "phrase": "Shop", "synonyms": ["Standort Adresse", "Adresse"] }, { "phrase": "Kontakt", "synonyms": ["Standort", "Telefonnummer"] }], "synonymSet": [["Telefon", "Handy", "Smartphone", "Natel"], ["Festnetz", "Telefon"]] }, "verticals": {} }, "fr": { "querySuggestions": { "popularQueriesBlacklistedTerms": [], "universalPrompts": ["Ou est le Shop de Evard?", "Wie kann ich mit Evard Kontakt aufnehmen?"], "verticalPrompts": {} }, "synonyms": { "normalization": [], "oneWay": [], "synonymSet": [["Phone", "Handy", "Smartphone", "Natel"]] }, "verticals": {} } };

    var lang = "de";
	
    var synonyme = 0;

    getYextBranches();

    onentersy();

    function auto_grow() {
        document.getElementById("builder-result").style.height = "5px";
        document.getElementById("builder-result").style.height = (document.getElementById("builder-result").scrollHeight) + "px";
    }

    function change() {

        if (Object.keys(json).length > 0 && lang != "") {
            var langList = "";
            var langButton = ""
            for (let i = 0; i < Object.keys(json).length; i++) {
                langList += "<div><p>" + Object.keys(json)[i] + "</p></div><div><button onclick=\"delLang('" + Object.keys(json)[i] + "')\">Remove Language</button></div>";
                langButton += '<button onclick="changelang(\'' + Object.keys(json)[i] + '\')">' + Object.keys(json)[i] + "</button>";
            }
            $("#builder-form-twoway").removeClass("displaynon");
            $("#builder-form-oneway").removeClass("displaynon");
            $("#popup-lang-list").html(langList);
            $("#language-buttons").html(langButton);
            console.log(config.length)
            if (config == "" || config.length == 0){
                $("#builder-result").val(JSON.stringify(json, undefined, 2));
            }else{
                $("#builder-result").val(JSON.stringify(config, undefined, 2));
            }
            

            var htmlsynonymset = "";
            for (var i = 0; json[lang].synonyms.synonymSet.length > i; i++) {
                htmlsynonymset += '<div><div nr="' + i + '">';

                for (var ii = 0; json[lang].synonyms.synonymSet[i].length > ii; ii++) {
                    htmlsynonymset += '<button onclick="rmSynonymSetTag(' + i + ', ' + ii + ')">' + json[lang].synonyms.synonymSet[i][ii] + '</button>';
                }

                htmlsynonymset += '<input type="text" class="synonymInput" nr="' + i + '" id="synonym-' + i + '" ';
                htmlsynonymset += '></div><button onclick="rmSynonymSet(' + i + ')">-</button></div>';
            }
            $(".synonymSetSet").html(htmlsynonymset);
            var htmlwaysynonymset = "";

            for (var i = 0; json[lang].synonyms.oneWay.length > i; i++) {
                htmlwaysynonymset += '<div><input type="text" nr="' + i + '" class="synonymWayInputPhr" value="' + json[lang].synonyms.oneWay[i].phrase + '"></input><button onclick="rmWaySynonymSet(' + i + ')">-</button><div nr="' + i + '">';
                for (var ii = 0; json[lang].synonyms.oneWay[i].synonyms.length > ii; ii++) {
                    htmlwaysynonymset += '<button onclick="rmWaySynonymSetTag(' + i + ', ' + ii + ')">' + json[lang].synonyms.oneWay[i].synonyms[ii] + '</button>';
                }

                htmlwaysynonymset += '<input type="text" class="synonymWayInput" nr="' + i + '" id="synonym-' + i + '" ';
                htmlwaysynonymset += '></div></div>';
            }
            $(".synonymWaySetSet").html(htmlwaysynonymset);
            onentersy();
            auto_grow();
        } else {
            $("#builder-form-twoway").addClass("displaynon");
            $("#builder-form-oneway").addClass("displaynon");
            $("#popup-lang-list").html("");
            $("#language-buttons").html("");
            $("#builder-result").val("Use the power of the form");
        }

    }

    $("#builder-result").focusout(function () {
        if (typeof JSON.parse($("#builder-result").val()).$schema === 'undefined'){
            json = JSON.parse($("#builder-result").val());
            config = "";
        }else{
            config = JSON.parse($("#builder-result").val());
            json = config.localizations;
        }
        change();
    });

    $("#builder-api #selectApi").change(function () {
		getYextBranches();
    })

    $("#builder-api #selectBranch").change(function () {
		getYextcode()
    })
	
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
		return false;
	};

	function getYextBranches(){
		if ($("#builder-api #selectApi").val() == "-"){
			json = {};
			change();
			history.pushState(null, "", "?");
			$("#builder-api #selectBranch").html('<option value="-">< Add AnswerAPI Key</option>');
		}else if($("#builder-api #selectApi").val() == "newapi"){
			openApipopup();
		}else{
			$.ajax({
				"url": "https://mylsintern.mls-test.ch/proxy.php?url=" + encodeURIComponent("https://api.yext.com/v2/accounts/me/config/answers/config?api_key="+ $("#builder-api #selectApi").val() +"&v=20161012"),
				"method": "GET", 
				dataType: "json",
				success: function (response) {
					selected = false;
					html = '<option value="-">< Add AnswerAPI Key</option>';
					console.log(response.response[1])
					if (response.response.length > 0){
						html = "";
						if (response.response.length == 1){
							html += '<option value="-">Choos Experience</option><option value="'+ response.response[0] + '" selected>'+ response.response[0] +"</option>";
							selected = true;
						}else{
							html += '<option value="-">Choos Experience</option>';
							for(var i = 0; i < response.response.length; i++) {
								html += '<option value="'+ response.response[i] + '" ';
								if (getUrlParameter("exp") == response.response[i]) {
									console.log("test");
									selected = true;
									html += 'selected';
								}
								html += '>'+ response.response[i] +"</option>";
							}
						}
					}
					console.log(html);
					$("#builder-api #selectBranch").html(html);
					if (selected){
						console.log("ist selected");
						getYextcode();
					}else{
						history.pushState(null, "", "?api="+ $("#builder-api #selectApi").val());
					}
				},
				error: function(){
					history.pushState(null, "", "?");
					$("#builder-api #selectBranch").html('<option value="-">< Add AnswerAPI Key</option>');
				}
			})
		}
	}
	
	function getYextcode(){
		if ($("#builder-api #selectBranch").val() == "-"){
			console.log("clear code");
			json = {};
			change();
			history.pushState(null, "", "?api="+ $("#builder-api #selectApi").val());
		}else{
			console.log("get the code");
			$.ajax({
				"url": "https://mylsintern.mls-test.ch/proxy.php?url=" + encodeURIComponent("https://api.yext.com/v2/accounts/me/config/answers/config/"+ $("#builder-api #selectBranch").val() +"?api_key="+ $("#builder-api #selectApi").val() +"&v=20161012"),
				"method": "GET", 
				dataType: "json",
				success: function (response) {
					console.log(response);
					config = response.response;
					console.log(config.localizations);
					json = config.localizations;
					change();
					history.pushState(null, "", "?api="+ $("#builder-api #selectApi").val() + "&exp=" + $("#builder-api #selectBranch").val());
				}
			})
		}
	}

    function delLang(lang) {
        delete json[lang];
        change();
    }

    function rmSynonymSet(nr) {
        json[lang].synonyms.synonymSet.splice(nr, 1);
        change();
    }

    function rmSynonymSetTag(nr, tagnr) {
        json[lang].synonyms.synonymSet[nr].splice(tagnr, 1);
        change();
    }

    function rmWaySynonymSet(nr) {
        json[lang].synonyms.oneWay.splice(nr, 1);
        change();
    }

    function rmWaySynonymSetTag(nr, tagnr) {
        json[lang].synonyms.oneWay[nr].synonyms.splice(tagnr, 1);
        change();
    }

    function changelang(langch) {
        lang = langch;

        $("#language-buttons button").css("border-bottom", "5px solid #888888");
        $(this).css("border-bottom", "5px solid #009432");
        change();
    }

    function openLangpopup() {
        $("#popup").removeClass("displaynon");
		$("#popup-lang").removeClass("displaynon");
    }
	
	function openApipopup() {
        $("#popup").removeClass("displaynon");
		$("#popup-api").removeClass("displaynon");
    }

    function closePopup() {
        $("#popup").addClass("displaynon");
		$(".popup").addClass("displaynon");
    }
	
	function reload() {
		location.reload();
	}
	

    function addLanguage() {
        langList = true;
        for (let i = 0; i < Object.keys(json).length; i++) {
            if ($('select[name="addLanguage"]').val() == Object.keys(json)[i]) {
                langList = false;
            }
        }
        if (langList) {
            json[$('select[name="addLanguage"]').val()] = { synonyms: { oneWay: [], synonymSet: [] } };
            change();
        }
    }
	
	function addApi(){
		$.post("backend.php",{
			addapi: "true",
			kunde: $("#apikd").val(),
			api: $("#apikey").val()
		});
	}
	
	function rmApi(api){
		$.post("backend.php",{
			rmapi: "true",
			api: api
		});
	}

    function onentersy() {
        $(".synonymInput").on('keypress', function (e) {
            if (e.which == 13) {
                if ($(this).val() != '') {
                    if (json[lang].synonyms.synonymSet[$(this).attr("nr")].indexOf($(this).val()) == -1) {
                        json[lang].synonyms.synonymSet[$(this).attr("nr")].push($(this).val());
                        change();
                        $(".synonymInput[nr=" + $(this).attr("nr") + "]").focus();
                    }
                }
            }
        });
        $(".synonymWayInput").on('keypress', function (e) {
            if (e.which == 13) {
                if ($(this).val() != '') {
                    if (json[lang].synonyms.oneWay[$(this).attr("nr")].synonyms.indexOf($(this).val()) == -1) {
                        json[lang].synonyms.oneWay[$(this).attr("nr")].synonyms.push($(this).val());
                        change();
                        $(".synonymWayInput[nr=" + $(this).attr("nr") + "]").focus();
                    }
                }
            }
        });
        $(".synonymWayInputPhr").focusout(function () {
            console.log($(this).val());
            console.log(json[lang].synonyms.oneWay[$(this).attr("nr")].phrase);
            if (json[lang].synonyms.oneWay[$(this).attr("nr")].phrase != $(this).val()) {
                json[lang].synonyms.oneWay[$(this).attr("nr")].phrase = $(this).val();
                change();
            }
            console.log(json[lang].synonyms.oneWay[$(this).attr("nr")].phrase);
        });
    }

    function addNewSynonym() {
        json[lang].synonyms.synonymSet.push([]);
        change();
    }

    function addNewWaySynonym() {
        json[lang].synonyms.oneWay.push({ "phrase": "", "synonyms": [] });
        change();
    }
	
	function savetoYext() {
		console.log(config);
		$.post("backend.php",{
			savetoYext: "true",
			branch: $("#builder-api #selectBranch").val(),
			api: $("#builder-api #selectApi").val(),
			config: JSON.stringify(config)
		});
	}































    /*var TagsInput = function (opts) {
        this.options = Object.assign(TagsInput.defaults, opts);
        this.original_input = document.getElementById(opts.selector);
        this.arr = [];
        this.wrapper = document.createElement('div');
        this.input = document.createElement('input');
        buildUI(this);
        addEvents(this);
    }


    TagsInput.prototype.addTag = function (string) {

        if (this.anyErrors(string))
            return;

        this.arr.push(string);
        var tagInput = this;


        var tag = document.createElement('span');
        tag.className = this.options.tagClass;
        tag.innerText = string;
        if(json[lang].synonyms[this.options.feldauswahl][this.options.feldnummer] == undefined){
            json[lang].synonyms[this.options.feldauswahl].push([]);
        }
        json[lang].synonyms[this.options.feldauswahl][this.options.feldnummer].push(string);
        change();

        var closeIcon = document.createElement('a');
        closeIcon.innerHTML = '&times;';
        closeIcon.addEventListener('click', function (e) {
            e.preventDefault();
            var tag = this.parentNode;

            for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
                if (tagInput.wrapper.childNodes[i] == tag)
                    tagInput.deleteTag(tag, i);
            }
        })


        tag.appendChild(closeIcon);
        this.wrapper.insertBefore(tag, this.input);
        this.original_input.value = this.arr.join(',');

        return this;
    }



    TagsInput.prototype.deleteTag = function (tag, i) {
        tag.remove();
        this.arr.splice(i, 1);
        json[lang].synonyms[this.options.feldauswahl][this.options.feldnummer].splice( i , 1);
        this.original_input.value = this.arr.join(',');
        change();
        return this;

    }


    TagsInput.prototype.anyErrors = function (string) {
        if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
            return true;
        }
        if (this.options.validator != undefined && !this.options.validator(string)) {
            console.error('Invalid input: ' + string)
            return true;
        }
        return false;
    }

    TagsInput.prototype.addData = function (array) {
        var plugin = this;

        array.forEach(function (string) {
            plugin.addTag(string);
        })
        return this;
    }


    TagsInput.prototype.getInputString = function () {
        return this.arr.join(',');
    }


    // Private function to initialize the UI Elements
    function buildUI(tags) {
        tags.wrapper.append(tags.input);
        tags.wrapper.classList.add(tags.options.wrapperClass);
        tags.original_input.setAttribute('hidden', 'true');
        tags.original_input.parentNode.insertBefore(tags.wrapper, tags.original_input);
    }



    function addEvents(tags) {
        tags.wrapper.addEventListener('click', function () {
            tags.input.focus();
        });
        tags.input.addEventListener('keydown', function (e) {
            var str = tags.input.value.trim();
            if (!!(~[9, 13, 188].indexOf(e.keyCode))) {
                tags.input.value = "";
                if (str != "")
                    tags.addTag(str);
            }
        });
    }


    TagsInput.defaults = {
        selector: '',
        wrapperClass: 'tags-input-wrapper',
        tagClass: 'tag',
        max: null,
        duplicate: false
    }


    window.TagsInput = TagsInput;

    var Tag1 = new TagsInput({
        selector: 'synonym-0',
        duplicate: false,
        feldauswahl: "synonymSet",
        feldnummer: 0
    });

















    function addNewSynonym(){
        synonyme++;
        $(".synonymSetSet").html($(".synonymSetSet").html() + '<input type="text" id="synonym-' + synonyme + '"><button onclick="addSynonymsTags(true)"></button>');
    }*/
</script>

</html>