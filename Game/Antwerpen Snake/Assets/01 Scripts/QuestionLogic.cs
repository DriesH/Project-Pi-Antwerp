using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class QuestionLogic : ReadJson {
  
  public Text questionText        = null; //the text where all the questions will appear
  public Text loadingText         = null;
  public GameObject questionPanel = null; //the panel that alternatively will be set to hide or appear

  protected static int currentQuestion     = 0; //so the script knows which question to show
  private string[] questions      = null;  //to save all the questions for the database
 
  //to get the script from the player so the variables of that script can be used
  public GameObject snake         = null;      
  protected SnakeV2 snakeScript   = null;  

  protected string[] projectIDs   = null; //saved in string to prevent constant converting, 
  protected string[] questionIDs  = null; //mag in string
  protected string answerUser     = "";

  void Start()
  {
    StartCoroutine(GetDatabase(urlProject, "Question")); //start the method from ReadJson so it's the first to begin

    snakeScript = snake.GetComponent<SnakeV2>(); //and get the script from this gameobject to check the bool later
    loadingText.enabled = true; //when the game starts, show the loadingtext
  }

  void LateUpdate(){
    if (readyToPlay) //check if all questions are loaded from the database
    {
      readyToPlay = false; //immediatly turn this false to prevent further looping
      loadInQuestions();
    }
  }

  void loadInQuestions() //moet vele later beginnen
  {
    if (numberOfQuestions > 0)
    { 
      questions   = new string[numberOfQuestions]; //make the array as long as the amount of questions found in the database
      questionIDs = new string[numberOfQuestions]; 

      for (int i = 0; i < databaseQuestions.Count; i++) 
      {
        questions[i]   = databaseQuestions[i]; //put each question from the databaselist into the questionArray
        questionIDs[i]  = databaseIDQuestions[i]; //put each ID from the database into the array
      }
    }
    loadingText.enabled = false; //hide the loadingtext

    ShowQuestion(); //retrieve the data of which question to show
  }

  void ShowQuestion()
  {
    if (questionText != null)
    {
      if (!snakeScript.isPlayingGame) //if the game is NOT playing (checks from snakeV2 script)
      {
        if (currentQuestion < numberOfQuestions) //there are still questions left
        {
          questionText.text = questions[currentQuestion]; //show the current question  ===> methode moet later opstarten
        }
        else if (currentQuestion >= numberOfQuestions) //no questions left
        {
          questionText.text = "Je hebt alle vragen beantwoord!";
        }
      }
    }
    else //if questiontext was null ==> use the next defaulttext
    {
      questionText.text = "Je hebt waarschijnlijk geen internetverbinding"; 
    }
    questionPanel.SetActive(true); // and show the panel
  }

  public void QuestionButtonPress(){ //when the button on the questionPanel is pressed
    snakeScript.isPlayingGame = true; //make sure the player can play the game
    questionPanel.SetActive(false); //hide the panel
    currentQuestion++; //flip to the next question
  }
}
