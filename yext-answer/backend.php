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

if(isset($_POST["addapi"])){
	$sql = "INSERT INTO `yext-answer-api`(`string_name`, `string_apikey`) VALUES ('" . $_POST["kunde"] . "','" . $_POST["api"] . "')";
	if ($conn->query($sql) === TRUE) {
  echo "Record add successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}
}
   
if(isset($_POST["rmapi"])){
	$sql = "DELETE FROM `yext-answer-api` WHERE `string_apikey`='" .  $_POST["api"] . "'";
	if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}
}

if(isset($_POST["savetoYext"])){
	/*$url = 'https://api.yext.com/v2/accounts/me/answers/config/'. $_POST["branch"] .'?api_key=' . $_POST["api"] . '&v=20161012';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_PUT, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST["config"]));
	$response = curl_exec($ch);

	echo $response;*/
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.yext.com/v2/accounts/me/answers/config/'. $_POST["branch"] .'?v=20161012&api_key='. $_POST["api"],
	  CURLOPT_CUSTOMREQUEST => 'PUT',
	  CURLOPT_POSTFIELDS =>$_POST["config"],
		CURLOPT_HTTPHEADER => array(
    'accept: application/json',
    'Content-Type: application/json'
  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;
	
	
	
	
	/*$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.yext.com/v2/accounts/me/answers/config/faq?v=20161012&api_key=1e9b137e7bd19ac394f0a8c63a7351aa',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
  "$schema": "https://schema.yext.com/config/answers/answers-config/v1",
  "$id": "faq",
  "name": "FAQ",
  "supportedLocales": ["de"],
  "countryRestrictions": [],
  "verticals": {
    "häufig_gestellte_fragen": {
      "entityTypes": [
        "faq"
      ],
      "name": "Häufig gestellte Fragen",
      "searchableFields": {
        "answer": {
          "textSearch": true
        },
        "builtin.entityType": {
          "nlpFilter": true
        },
        "keywords": {
          "textSearch": true
        },
        "question": {
          "semanticTextSearch": true
        }
      },
      "sortBys": [],
      "source": "KNOWLEDGE_MANAGER"
    },
    "standorte": {
      "entityTypes": [
        "location"
      ],
      "name": "Standorte",
      "searchableFields": {
        "builtin.entityType": {
          "nlpFilter": true
        },
        "builtin.location": {
          "nlpFilter": true
        },
        "keywords": {
          "phraseMatch": true
        },
        "name": {
          "textSearch": true
        }
      },
      "sortBys": [],
      "source": "KNOWLEDGE_MANAGER"
    }
  },
  "synonyms": {
    "oneWay": [],
    "synonymSet": [
      [
        "Telefon",
        "Festnetz",
        "anrufen",
        "telefonieren",
        "Telefonie",
        "Anrufe"
      ],
      [
        "Rufumleitung",
        "Weiterleitung"
      ],
      [
        "Vertrag",
        "Rechnung",
        "Einzahlung",
		"Test"
      ]
    ]
  },
  "localizations": {
    "de": {
      "synonyms": {
        "oneWay": [],
        "synonymSet": []
      }
    }
  },
  "additionalSearchablePlaces": [],
  "querySuggestions": {
    "disablePopularQueries": false,
    "verticalPromptsOnEmpty": false,
    "popularQueriesBlacklistedTerms": [],
    "universalPrompts": [
      "Fragen um Telefon",
      "Fragen um Internet",
      "Fragen um Radio und TV"
    ],
    "verticalPrompts": {
      "häufig_gestellte_fragen": [
        "[[name]]"
      ],
      "standorte": [
        "Locations near [[address.city]]",
        "Locations near [[address.region]]"
      ]
    }
  }
}',
  CURLOPT_HTTPHEADER => array(
    'accept: application/json',
    'Content-Type: application/json',
    'Cookie: __cf_bm=WqM2ZZjXBPoidwwYzD9eidRoKg23PEy_eYNR5DSAXNs-1648654094-0-AXKQdOmYDnuqmZLiDzepT933xDephRpfcMAvCeoDRzUzMABUTklF2sxgbfLH8oRn7DYXDCdUzM+mVG1uJpYJbVhT5Y9y29K9UiBwcQS/M9L3'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;*/

}
?>