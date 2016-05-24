using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;
using System.Collections.Generic;

public class ReadJson : MonoBehaviour {
  
  private JsonData itemData                         = null; //the data that will be used to select the data needed from the json file
  protected string urlProject                       = "http://pi.multimediatechnology.be/API/get/projecten"; //the url where to find the json file
  protected string urlQuestion                      = ""; //the url where to find the json file ==> nog aanpassen

  protected static List<string> databaseTitles       = new List<string>(); //titles of the projects that need to be loaded from the database
  protected static List<string> databaseDescriptions = new List<string>(); //descriptions of the projects that need to be loaded from the database
  protected static List<string> databaseImages       = new List<string>(); //images of the projects that need to be loaded from the database (saven in longtext in database)
  protected static List<string> databaseIDProjects   = new List<string>(); //the id of the projects that need to be loaded from the database to follow the URL (in string since it has to be a string later on anyway)
  
  protected static List<string> databaseQuestions    = new List<string>(); //load the questions from the database in this
  protected static List<string> databaseIDQuestions  = new List<string>(); //load the questions ID from the database in this
  protected static List<string> databaseIDProjectQuestions = new List<string>(); //load the ID that link to the question from the database in this

  protected static int numberOfProjects              = 0; //the number of total projects is standard 0
  protected static int numberOfQuestions             = 0; //the number of total questions is standard 0
  protected static bool readyToBuild                 = false; //so the other scripts know when to start builing the panels
  protected static bool readyToPlay                  = true; //so the other scripts know when to start playing the game
	// ==> readtoPLay nog terug op false zetten!!


  protected IEnumerator GetDatabase(string url, string GetInfoFromThisDatabase)
  {
    WWW www = new WWW(url);      // Start a download of the given URL
    yield return www;      // Wait for download to complete

    if (GetInfoFromThisDatabase == "Project") //get the data from the ProjectApi
    {
      GetProjectInfoFromDatabase(www.text);
    }
    else if (GetInfoFromThisDatabase == "Question") //get the data from the QuestionApi
    {
      GetQuestionsFromDatabase(www.text);
    }
  }

  void GetProjectInfoFromDatabase(string urlApi) //if there is nothing declared before void, the method is always private
  {
    itemData = JsonMapper.ToObject(urlApi); //parse it into a JsonObject

    for (int i = 0; i < itemData["projecten"].Count; i++) //for each project
    {
      //always try to parse them into a string, just to be sure
      databaseTitles.Add((string)itemData["projecten"][i]["naam"]); //read in eveything from the database that has the key 'projecten' and the value 'name'
      databaseDescriptions.Add((string)itemData["projecten"][i]["uitleg"]);//read in eveything from the database that has the key 'projecten' and the value 'uitleg'
      databaseIDProjects.Add((string)itemData["projecten"][i]["idProject"]); //read in eveything from the database that has the key 'projecten' and the value 'idProject'
      databaseImages.Add((string)itemData["projecten"][i]["foto"]); //read in eveything from the database that has the key 'projecten' and the value 'foto'
    }
    numberOfProjects = itemData["projecten"].Count; //so the rest of the scripts know how many projects there are
    readyToBuild = true; //so the other scripts know when they can start
  }

  void GetQuestionsFromDatabase(string urlApi)  //===> nog aanpassen
  {
    itemData = JsonMapper.ToObject(urlApi); //parse it into a JsonObject

    for (int i = 0; i < itemData["Vragen"].Count; i++) //for each project
    {
      databaseQuestions.Add((string)itemData["Vrgan"][i]["nog iets?"]); //==> nog aanpassen
      databaseIDQuestions.Add((string)itemData["vragen"][i]["id"]); //nog aanpassen
      databaseIDProjectQuestions.Add((string)itemData["vragen"][i]["idproject"]); //nog aanpassen
    }
    numberOfQuestions = itemData["vragen"].Count; // ==> nog aanpassen
    readyToPlay = true;
  }
 }
