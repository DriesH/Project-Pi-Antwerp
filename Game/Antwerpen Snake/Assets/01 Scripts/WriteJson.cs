using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
using LitJson;

public class WriteJson : QuestionLogic { // ==> andere naam geven OVERERVEN VAN QUESTIONLOGIC (als je overerft, gaat er iets mis)

 // private JsonData dataForFeedback  = null; //the data that will be used to select the data needed from the json file
  
  //overerven van questionlogic
  private string writeURL           = "";
  private string currQuestionID     = ""; //mag in string
  private string currAnswerUser     = ""; //echt het woord typen

  void LateUpdate()
  {
    if (whatWasPickedUp != null && whatWasPickedUp != "") //if an answer is given
    {
      currQuestionID = questionIDs[currentQuestion-1]; //because the next question is already loaded
      WhichAnswer(whatWasPickedUp); //to get answerUser
      SnakeV2.whichFoodwasPickedUp = null; //reset the whole pickedupvariable
      
      //DON'T CHANGE URL
      writeURL = "http://pi.multimediatechnology.be/API/post/projecten/antwoord?questionID=" + currQuestionID + "&answerUser=" + currAnswerUser;
      StartCoroutine(writeToServer(currQuestionID, currAnswerUser));
    }
  }


  IEnumerator writeToServer (string questionID, string answerUser) { 
    WWW www = new WWW(writeURL); 
    yield return www;

    if (www.error == null || !www.text.StartsWith("<!DOCTYPE html>")) //if there is not an error and the page isn't a normal html file
    { 
      readAllForFeedback(www.text);
    }

    Debug.Log("Getalkt met server.");
  }

  void readAllForFeedback(string feedbackURL)
  {
     //dataForFeedback = JsonMapper.ToObject(feedbackURL); //parse it into a JsonObject

    //data nog inlezen voor feedback => nog percentteken toevoegen
    //==> enkel feedback voor gekozen antwoord
  }

  void WhichAnswer(string food_tag) //to see which answer was given to it can be sent to the server
  {
    switch (food_tag)
    { 
      case "food_1":
        currAnswerUser = "zeer_eens";
        break;
      case "food_2":
        currAnswerUser = "eens";
        break;
      case "food_3":
        currAnswerUser = "oneens";
        break;
      case "food_4":
        currAnswerUser = "zeer_oneens";
        break;
      default: //in case a wrong tag is given, this is the defaultanwser
        currAnswerUser = "zeer_eens";
        break;
    }
  }
}