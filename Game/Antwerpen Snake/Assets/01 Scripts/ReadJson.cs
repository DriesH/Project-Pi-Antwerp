using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;
using System.Collections.Generic;

public class ReadJson : MonoBehaviour
{
  private JsonData itemData                           = null; //the data that will be used to select the data needed from the json file
  protected string urlProject                         = "http://pi.multimediatechnology.be/API/get/projecten"; //the url where to find the json file

  protected static List<string> databaseTitles        = new List<string>(); //titles of the projects that need to be loaded from the database
  protected static List<string> databaseDescriptions  = new List<string>(); //descriptions of the projects that need to be loaded from the database
  protected static List<string> databaseImages        = new List<string>(); //images of the projects that need to be loaded from the database (saven in longtext in database)
  protected static List<string> databaseIDProjects    = new List<string>(); //the id of the projects that need to be loaded from the database to follow the URL (in string since it has to be a string later on anyway)

  protected static List<string> databaseQuestions     = new List<string>(); //load the questions from the database in this
  protected static List<string> databaseIDQuestions   = new List<string>(); //load the questions ID from the database in this

  protected static int numberOfProjects               = 0; //the number of total projects is standard 0
  protected static int numberOfQuestions              = 0; //the number of total questions is standard 0
  protected static bool readyToBuild                  = false; //so the other scripts know when to start builing the panels
  protected static bool readyToPlay                   = false; //so the other scripts know when to start playing the game

  protected IEnumerator GetDatabase(string url, string GetInfoFromThisDatabase)
  {
    WWW www = new WWW(url); // Start a download of the given URL
    yield return www;       // Wait for download to complete

    if (www.error == null) //if there is no error
    {
      if (GetInfoFromThisDatabase == "Project") //get the data from the ProjectApi
      {
        GetProjectInfoFromDatabase(www.text);
      }
      else if (GetInfoFromThisDatabase == "Question") //get the data from the QuestionApi
      {
        GetQuestionsFromDatabase(www.text);
      }
    }
    else //when nothing could be loaded for some reason
    {
      numberOfQuestions = 0;
      numberOfProjects = 0;
    }
  }

  void GetProjectInfoFromDatabase(string urlApi) //if there is nothing declared before void, the method is always private
  {
    if (!urlApi.StartsWith("<!DOCTYPE html>")) //if the database could load and isn't a regular HTMLpage
    {
      itemData = JsonMapper.ToObject(urlApi); //parse it into a JsonObject

      for (int i = 0; i < itemData["projecten"].Count; i++) //for each project
      {
        //always try to parse them into a string, just to be sure
        databaseTitles.Add      ((string)itemData["projecten"][i]["naam"]);       //read in all from database that has the key 'projecten' and the value 'name'
        databaseDescriptions.Add((string)itemData["projecten"][i]["uitleg"]);     //read in all from database that has the key 'projecten' and the value 'uitleg'
        databaseIDProjects.Add  ((string)itemData["projecten"][i]["idProject"]);  //read in all from database that has the key 'projecten' and the value 'idProject'
        databaseImages.Add      ((string)itemData["projecten"][i]["foto"]);       //read in all from database that has the key 'projecten' and the value 'foto'
        numberOfProjects = itemData["projecten"].Count;//so the rest of the scripts know how many projects there are
      }
    }
    else //if the database couldn't be loaded
    {
      numberOfProjects = 0; //default value
    }
    readyToBuild = true; //so the other scripts know when they can start
  }

  void GetQuestionsFromDatabase(string urlApi)
  {
    if (!urlApi.StartsWith("<!DOCTYPE html>")) //if the database could load and isn't a regular HTMLpage
    {
      itemData = JsonMapper.ToObject(urlApi); //parse it into a JsonObject

      for (int i = 0; i < itemData["appvragen"].Count; i++) //for each member in appvragen
      {
        databaseQuestions.Add         ((string)itemData["appvragen"][i]["question"]);       //read in all from database that has the key 'appvragen' and the value 'question'
        databaseIDQuestions.Add       ((string)itemData["appvragen"][i]["idAppquestions"]); //read in all from database that has the key 'appvragen' and the value 'idAppquestions'
      }
      numberOfQuestions = itemData["appvragen"].Count;
    }
    else //if the database couldn't be loaded
    {
      numberOfQuestions = 0; //default value
    }
    readyToPlay = true; //so te other scripts know when they can start the game
  }
 }