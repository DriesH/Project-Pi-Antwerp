using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;

public class PanelProject : ReadJson //the only thing to check ==> setparent method
{
  public GameObject listOfPanels          = null; ///this is where all the panels needs to be put in
  public GameObject panel                 = null; //this is a panel of 1 project
  public Image      projectImage          = null; //image of a project
  public Text       projectTitleText      = null; //text of a project
  public Text       projectDescrText      = null; //the short description of a project;
  public GameObject emptySpot             = null; //this is for the empty slot at the bottom of the page
  public Text       noProjectText         = null; //show some text when there are no projects or when there wasn't internet
  public GameObject loadingText           = null; //show when everything is loading from database
  public Scrollbar  bar                   = null; //drop the scrollbar in here

  private const float startValueScrollbar = 1f; //makes sure the scrollbar is always starting at the top of the page
  private string[]    imageUrls           = null; //to get the images from the website
  private Sprite[]    savedSprites        = null; //to save the images that came from the website
  private const short lenghtOfDescrp      = 250; //the length of description to show in the panel
  private const short lenghtOfTitle       = 22; //the length of the title to show in panel ==> can't be higher than this or it crashes
  private const float pivotPoint          = 0.5f; //the pivotpoint of the picture

  void Start()
  { 
    noProjectText.enabled = false; //start with hiding the text 
    loadingText.SetActive(true); //show this text

    StartCoroutine(GetDatabase(urlProject, "Project")); //start the method from ReadJson so it's the first to begin
  }

  void LateUpdate()
  {
    if (readyToBuild && numberOfProjects > 0) //when GetInfoFromDatabase has been completed, readyToBuild will be set to true
    {
      readyToBuild = false; //set it back to false so it will be done one time
      StartCoroutine(LoadImageUrl()); //start the IEnumerator LoadImageUrl()
    }
  }

  IEnumerator LoadImageUrl()
  {
    imageUrls    = new string[numberOfProjects];
    savedSprites = new Sprite[numberOfProjects];

    for (int i = 0; i < numberOfProjects; i++)
    {
      imageUrls[i] = "http://pi.multimediatechnology.be" + databaseImages[i];
      // Start a download of the given URL
      WWW www = new WWW(imageUrls[i]);

      // Wait for download to complete
      yield return www;

      if (www.error == null)
      { 
        Sprite sprite = new Sprite();
        sprite = Sprite.Create(www.texture, new Rect(0, 0, www.texture.width, www.texture.height), new Vector2(pivotPoint, pivotPoint)); //same size and pivot as the prefabimage
        savedSprites[i] = sprite; //save the sprites in an array for the MakePanels()-method
        www.Dispose(); //get rid of the www so the next one can be loaded
      }
    }
    MakePanels();
  }

  void MakePanels()
  {
    if (numberOfProjects <= 0)//when there are no projects
    {
      noProjectText.enabled = true; //show the text
    }
    else if (numberOfProjects > 0) //if there is atleast 1 project
    {
      for (int i = 0; i < numberOfProjects; i++) //for every project
      {
       // projectDescrText.text = databaseDescriptions[i].Substring(0,lenghtOfDescrp) + "..."; //reads in all the database descriptions and shortens them so they always fit
        projectDescrText.text = databaseDescriptions[i];
        projectTitleText.text = databaseTitles[i];
      //  projectTitleText.text = databaseTitles[i].Substring(0, lenghtOfTitle) + "..."; //reads in all the database titles and shortens them so they always fit
        
        projectImage.sprite = savedSprites[i]; //reads in the sprites 

        //make a new panel with all the parameters from above and place it within listOfPanels
        GameObject childObject = Instantiate(panel);
        childObject.transform.SetParent(listOfPanels.transform); 
      }
      //make the empty space at the bottom so there is some padding
      GameObject empty = Instantiate(emptySpot) as GameObject;
      empty.transform.SetParent(listOfPanels.transform);
      if (bar != null) //if there is a scrollbar, place it at the top of the page (loaded at last for the best result)
      {
        bar.value = startValueScrollbar;
      }
    }
    loadingText.SetActive(false); //hide the loadingtext
  }
}
