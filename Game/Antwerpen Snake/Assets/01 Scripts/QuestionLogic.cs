using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class QuestionLogic : ReadJson {
  
  public Text questionText        = null; //the text where all the questions will appear
  public GameObject questionPanel = null; //the panel that alternatively will be set to hide or appear
  public Button okButton          = null; //show the button when the questions have been loaded

  protected static int currentQuestion     = 0; //so the script knows which question to show
  private string[] questions      = null;  //to save all the questions for the database
 
  protected static string[] projectIDs   = null; //saved in string to prevent constant converting, to save the data from the database
  protected static string[] questionIDs  = null; //saved in string to prevent constant converting, to save the data from the database
  protected string whatWasPickedUp = ""; //make sure nothing was picked up at the start
  private bool questionsLoaded     = false; //show the question when the questions are loaded

  void Start()
  {
    okButton.interactable = false; //make the button disabled so it can't be clicked when the questions haven't loaded
    if (this.tag == "Buttontest") //make sure that this script that is linked to several objects, only is excecuted when it's linked to the tag Buttontest
    { 
    StartCoroutine(GetDatabase(urlProject, "Question")); //start the method from ReadJson so it's the first to begin
    }
  }

  void Update(){
    while (readyToPlay) //check if all questions are loaded from the database
    {
      readyToPlay = false; //immediatly turn this false to prevent further looping
      loadInQuestions();
    } 

    while (questionsLoaded) //when the questions have been loaded
    {
      questionsLoaded = false; //immediatly turn this to false to prevent further looper
      ShowQuestion(); //retrieve the data of which question to show
    }
    whatWasPickedUp = SnakeV2.whichFoodwasPickedUp; //check if the snake picked up some food
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
    okButton.interactable = true; //the questions have loaded so make the button interactable
    questionsLoaded = true;
  }

  void ShowQuestion()
  {
    questionPanel.SetActive(true); // and show the panel
    if (questionText != null && questions != null)
    {
      if (!SnakeV2.isPlayingGame) //if the game is NOT playing (checks from snakeV2 script)
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
  }

  public void QuestionButtonPress(){ //when the button on the questionPanel is pressed
    SnakeV2.isPlayingGame = true; //make sure the player can play the game
    questionPanel.SetActive(false); //hide the panel
    if (currentQuestion < numberOfQuestions) //stop counting when there are no questions left
    { 
      currentQuestion++; //flip to the next question
    }
    questionsLoaded = true; //load the next question
  }
}
