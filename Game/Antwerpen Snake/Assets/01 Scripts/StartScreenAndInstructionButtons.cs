using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class StartScreenAndInstructionButtons : MonoBehaviour {

  public void StartGame() //start the game
  {
    Application.LoadLevel("NewSnakeGame");
  }

  public void ShowInstructions() //go to the page with instructions
  {
    Application.LoadLevel("Instructions");
  }
  
  public void GoToStartScreenGame() //go to the main menu of the game
  {
    Application.LoadLevel("MainScreenSnake");
  }
}
