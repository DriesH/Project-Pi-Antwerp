using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using LitJson;

public class SendData_GrabFeedback1 : QuestionLogic {

  private JsonData dataForFeedback  = null; //the data that will be used to select the data needed from the json file
  private int data;
  private int nData;
  private int hundred = 100;
  
  //overerven van questionlogic
  private string writeURL           = ""; //the url to write to
  private string currQuestionID     = ""; //used to get the ID of the current quesion
  private string currAnswerUser     = ""; //used to get the current question

  public Text percentage = null;//content of feedback
  public Text nPercentage = null;

  void LateUpdate()
  {
    if (whatWasPickedUp != null && whatWasPickedUp != "") //if an answer is given
    {
        if (currentQuestion < numberOfQuestions)
        { 
          currQuestionID = questionIDs[currentQuestion-1]; //because the next question is already loaded, so you need to get the previous question
          WhichAnswer(whatWasPickedUp); //to get answerUser
          SnakeV2.whichFoodwasPickedUp = null; //reset the whole pickedupvariable
      
          //DON'T CHANGE URL, post the anwser to the URL down here using the parameters
          writeURL = "http://pi.multimediatechnology.be/API/post/projecten/antwoord?questionID=" + currQuestionID + "&answerUser=" + currAnswerUser;
          StartCoroutine(writeToServer(currQuestionID, currAnswerUser));
        } 
     }
  }


  IEnumerator writeToServer (string questionID, string answerUser) {
    
    WWW www = new WWW(writeURL); //use the given url to sent the data to
    yield return www; //wait till it's done

    if (www.error == null || !www.text.StartsWith("<!DOCTYPE html>")) //if there is not an error and the page isn't a normal html file
    { 
      readAllForFeedback(www.text); //also read in the feedback that you get from this url
    }
  }

  void readAllForFeedback(string feedbackURL)
  {
     dataForFeedback = JsonMapper.ToObject(feedbackURL); //parse it into a JsonObject
     data = (int)dataForFeedback["feedback"][0]["percentage"]; //read in the data needed for the feedback
     percentage.text = data + "% is met u eens";
     nData = hundred - data;
     nPercentage.text = nData + "% is niet met u eens";
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
