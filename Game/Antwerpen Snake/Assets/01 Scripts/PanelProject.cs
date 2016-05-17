using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;

public class PanelProject : ReadJson
{
  public GameObject listOfPanels = null; ///this is where all the panels needs to be put in
  public GameObject panel = null; //this is a panel of 1 project
  public Image projectImage; //image of a project
  public Text projectTitleText; //text of a project
  public Text projectDescrText; //the short description of a project;
  public GameObject emptySpot = null; //this is for the empty slot at the bottom of the page
  public Text noProjectText; //show some text when there are no projects or when there wasn't internet

  private const float startValueScrollbar = 1f; //makes sure the scrollbar is always starting at the top of the page
  public Scrollbar bar = null; //drop the scrollbar in here
  private string[] imageUrl;

  void Start()
  {
    noProjectText.enabled= false;
 //   StartDatabase(); //start up the database and query
    imageUrl = new string[numberOfProjects];
  
   // StartCoroutine(LoadUrl());
    if (numberOfProjects <= 0)
    {
      noProjectText.enabled = true;
    }
    else if (numberOfProjects > 0) //if there is atleast 1 project
    {
      for (int i = 0; i < numberOfProjects; i++) //for every project
      {
        projectDescrText.text = databaseDescriptions[i]; //reads in all the database descriptions
        projectTitleText.text = databaseTitles[i]; //reads in all the database Titel

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

  IEnumerator LoadUrl()
  {
    for (int i = 0; i <= numberOfProjects; i++)
    {
      imageUrl[i] = "http://pi.multimediatechnology.be" + databaseImages[i];

      // Start a download of the given URL
      WWW www = new WWW(imageUrl[i]);

      // Wait for download to complete
      yield return www;

      Sprite sprite = new Sprite();
      sprite      = Sprite.Create(www.texture, new Rect(0, 0, 3.008f , 2.0f), new Vector2(0, 0));

      projectImage.sprite = sprite;
      www.Dispose();
      }
  }
}
