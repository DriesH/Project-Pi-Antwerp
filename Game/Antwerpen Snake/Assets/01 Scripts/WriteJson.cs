using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using LitJson;

public class WriteJson : MonoBehaviour { // ==> andere naam geven OVERERVEN VAN QUESTIONLOGIC (als je overerft, gaat er iets mis)

  private JsonData dataForFeedback  = null; //the data that will be used to select the data needed from the json file
  
  //overerven van questionlogic
  private string writeURL           = "";
  private string currQuestionID     = ""; //mag in string
  private string answerUser         = ""; //echt het woord typen

	void Start () {

   /* //testdata
    currQuestionID = "23";
    answerUser = "zeer_eens";

    writeURL = "http://pi.multimediatechnology.be/API/post/projecten/antwoord?questionID=" + currQuestionID + "&answerUser=" + answerUser;
    StartCoroutine(writeToServer());*/
	}

  void LateUpdate()
  {
    /*if (snakeScript.whichFoodwasPickedUp != "") //if an answer is given
    {
      currQuestionID = questionIDs[currentQuestion];
  
      WhichAnswer(boolChecker.whichFoodwasPickedUp); //to get answerUser
      boolChecker.whichFoodwasPickedUp = ""; //reset this variable
      
      //DON'T CHANGE URL
      writeURL = "http://pi.multimediatechnology.be/API/post/projecten/antwoord?questionID=" + currQuestionID + "&answerUser=" + answerUser;
      StartCoroutine(writeToServer());
    }*/
  }


  IEnumerator writeToServer () { 
    WWW www = new WWW(writeURL); //stuurt form naar URL
    yield return www;

    if (www.error == null)
    { 
      readAllForFeedback(www.text);
    }

    Debug.Log("Getalkt met server.");
  }

  void readAllForFeedback(string feedbackURL)
  {
     dataForFeedback = JsonMapper.ToObject(feedbackURL); //parse it into a JsonObject

    //data nog inlezen voor feedback => nog percentteken toevoegen
    //==> enkel feedback voor gekozen antwoord
  }

  void WhichAnswer(string food_tag) //to see which answer was given to it can be sent to the server
  {
    switch (food_tag)
    { 
      case "food_1":
        answerUser = "zeer_eens";
        break;
      case "food_2":
        answerUser = "eens";
        break;
      case "food_3":
        answerUser = "oneens";
        break;
      case "food_4":
        answerUser = "zeer_oneens";
        break;
      default: //in case a wrong tag is given, this is the defaultanwser
        answerUser = "zeer_eens";
        break;
    }
  }
}