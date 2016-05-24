using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using LitJson;

public class WriteJson : QuestionLogic { // ==> andere naam geven

  private JsonData dataForFeedback  = null; //the data that will be used to select the data needed from the json file
  
  //overerven van questionlogic
  private string writeURL           = "";
  private string currProjectID      = ""; //mag in string
  private string currQuestionID     = ""; //mag in string
  private string answerUser         = ""; //echt het woord typen

	void Start () {

    //testdata
   /* currProjectID = "10";
    currQuestionID = "5";
    answerUser = "zeer_eens";*/
	}

  void LateUpdate()
  { 
    if (boolChecker.whichFoodwasPickedUp != "") //if an answer is given
    {
      currProjectID  = projectIDs[currentQuestion];
      currQuestionID = questionIDs[currentQuestion];
  
      WhichAnswer(boolChecker.whichFoodwasPickedUp); //to get answerUser
      boolChecker.whichFoodwasPickedUp = ""; //reset this variable
      
      //DON'T CHANGE URL
      writeURL = "http://pi.multimediatechnology.be/API/post/projecten/antwoord?projectID=" + currProjectID + "&questionID=" + currQuestionID + "&answerUser=" + answerUser;
      StartCoroutine(writeToServer());
    }
  }


  IEnumerator writeToServer () { 
    WWW www = new WWW(writeURL); //stuurt form naar URL
    yield return www;

    readAllForFeedback(www.text);

    //status teruggestuurd  met www.text ==> uitprinten ==> zien hoe we enkel die status kunnen krijgen (eerste lijn?)

    Debug.Log("Getalkt met server.");
  }

  void readAllForFeedback(string feedbackURL)
  {
     dataForFeedback = JsonMapper.ToObject(feedbackURL); //parse it into a JsonObject

    //data nog inlezen voor feedback, pie chart
  }

  void WhichAnswer(string food_tag)
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