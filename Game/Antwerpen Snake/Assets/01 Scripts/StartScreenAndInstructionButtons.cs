﻿using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class StartScreenAndInstructionButtons : MonoBehaviour {
  //klasse voor de knoppen van het startscherm van het spel, knoppen van het instructiescherm, knoppen van de lijst van projecten
 
      public void StartGame() //start het spel op
      {
        Application.LoadLevel("SnakeGame");
      }

      public void ShowInstructions() //gaat naar de pagina met instructies
      {
        Application.LoadLevel("Instructions");
      }

      public void GoToStartScreenGame()
      {
        Application.LoadLevel("MainScreenSnake");
      }
}
