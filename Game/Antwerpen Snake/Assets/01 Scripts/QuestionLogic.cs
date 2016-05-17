using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class QuestionLogic : SnakeV2 {
  
  public Text questionText = null;
 // public GameObject questionPanel = null;

  private int numberOfQuestions = 3;
  private int currentQuestion = 0;
  private string[] questions;

  protected SnakeV2 boolChecker;

  void Start()
  {
    GameObject g = GameObject.FindGameObjectWithTag("Player");
    boolChecker = g.GetComponent<SnakeV2>();

    questionPanel.SetActive(true);
    questions = new string[numberOfQuestions];
    questions[0] = "Op elke boom moet een vuilbak staan.";
    questions[1] = "Er moeten minder auto's in de binnenstad kunnen rijden.";
    questions[2] = "De fietspaden int Antwerpen zijn niet veilig genoeg.";
  }

	void Update() {
    if (!boolChecker.isPlayingGame) //if the game is NOT playing 
    {
      if (currentQuestion < numberOfQuestions) //there are still questions left
      {
        questionText.text = questions[currentQuestion];
        questionPanel.SetActive(true);
      }
      else if (currentQuestion >= numberOfQuestions) //no questions left
      {
        questionText.text = "Je hebt alle vragen beantwoord!";
      }
    }
	}

  public void QuestionButtonPress() //when the button on the questionPanel is pressed
  {
    boolChecker.isPlayingGame = true;
    questionPanel.SetActive(false);
    currentQuestion++;
  }
}
