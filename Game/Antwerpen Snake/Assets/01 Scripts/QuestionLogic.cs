﻿using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class QuestionLogic : ReadJson {
  
  public Text questionText        = null; //the text where all the questions will appear
  public Text loadingText         = null;
  public GameObject questionPanel = null; //the panel that alternatively will be set to hide or appear

  private int currentQuestion     = 0; //so the script knows which question to show
  private string[] questions;     //to save all the questions for the database

  private SnakeV2 boolChecker;  //to save the script to check the bool in this script
  public GameObject snake;      //also used to check the bool

  void Start()
  {
//    StartCoroutine(GetDatabase(urlProject, "Question")); //start the method from ReadJson so it's the first to begin

    boolChecker = snake.GetComponent<SnakeV2>(); //and get the script from this gameobject to check the bool later
    loadingText.enabled = true;
  }

	void Update() {
    if (!boolChecker.isPlayingGame) //if the game is NOT playing (checks from snakeV2 script)
    {
      if (currentQuestion < numberOfQuestions) //there are still questions left
      {
        questionText.text = questions[currentQuestion]; //show the current question
        questionPanel.SetActive(true); // and show the panel
      }
      else if (currentQuestion >= numberOfQuestions) //no questions left
      {
        questionText.text = "Je hebt alle vragen beantwoord!";
      }
    }
	}

  void LateUpdate(){
    if (readyToPlay)
    {
      readyToPlay = false;
      loadInQuestions();
    }
  }

  void loadInQuestions()
  {
    questionPanel.SetActive(true); //show the panel when the game starts
    questions = new string[numberOfQuestions]; //make the array as long as the amount of questions found in the database
    for (int i = 0; i < databaseQuestions.Count; i++) //put each question from the databaselist into the questionArray
    {
      questions[i] = databaseQuestions[i];
    }
    loadingText.enabled = false;
  }

  public void QuestionButtonPress(){ //when the button on the questionPanel is pressed
    boolChecker.isPlayingGame = true; //make sure the player can play the game
    questionPanel.SetActive(false); //hide the panel
    currentQuestion++; //flip to the next question
  }
}
