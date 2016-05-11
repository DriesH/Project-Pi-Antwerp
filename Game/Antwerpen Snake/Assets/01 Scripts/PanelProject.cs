using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class PanelProject : DatabaseLogic {

   public GameObject listOfPanels = null; ///this is where all the panels needs to be put in
   public GameObject panel = null; //this is a panel of 1 project
   public Image projectImage; //image of a project
   public Text projectTitelText; //text of a project
   public Text projectDescrText; //the short description of a project;
   public GameObject emptySpot = null; //this is for the empty slot at the bottom of the page
  
   public const float startValueScrollbar = 1f; //makes sure the scrollbar is always starting at the top of the page
   public Scrollbar bar = null; //drop the scrollbar in here

   //testimages
   public Sprite testImage1;
   public Sprite testImage2;
   public Sprite testImage3;

  void Start () {
    StartDatabase(); //start up the database and query

    for (int i = 0; i < numberOfProjects; i++) //for every project
    {
      projectTitelText.text = databaseTitels[i];
      projectDescrText.text = databaseDescriptions[i];
      //projectImage.sprite = databaseImages[i];

    //make a new panel with all the parameters from above and place it within listOfPanels
    GameObject childObject = Instantiate(panel);
    childObject.transform.parent = listOfPanels.transform;
    }

    //make the empty space at the bottom
    GameObject empty = Instantiate(emptySpot) as GameObject;
    empty.transform.parent = listOfPanels.transform;

    if (bar != null) //if there is a scrollbar, place it at the top of the page (loaded at last for the best result)
    {
      bar.value = startValueScrollbar;
    }     
	}
}
