using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;
using System.Collections.Generic;

public class ReadJson : MonoBehaviour {
  
  private JsonData itemData; //the data that will be used to select the data needed from the json file
  protected string urlString                         = "http://pi.multimediatechnology.be/API/get/projecten"; //the url where to find the json file

  protected static List<string> databaseTitles       = new List<string>(); //titels of the projects that need to be loaded from the database
  protected static List<string> databaseDescriptions = new List<string>(); //descriptions of the projects that need to be loaded from the database
  protected static List<string> databaseImages       = new List<string>(); //images of the projects that need to be loaded from the database (saven in longtext in database)
  protected static List<string> databaseIDProjects   = new List<string>(); //the id of the projects that need to be loaded from the database to follow the URL (in string since it has to be a string later on anyway)

  protected static int numberOfProjects              = 0; //the number of total projects is standard 0
  protected static bool readyToBuild                 = false; //so the other scripts know when to start builing the panels
	
  protected IEnumerator GetDatabase(string url)
  {
    WWW www = new WWW(url);      // Start a download of the given URL
    yield return www;      // Wait for download to complete
    GetInfoFromDatabase(www.text);
   }

  void GetInfoFromDatabase(string urlApi) //if there is nothing declared before void, the method is always private
  {
    itemData = JsonMapper.ToObject(urlApi); //parse it into a JsonObject

    for (int i = 0; i < itemData["projecten"].Count; i++) //for each project
    {
      databaseTitles.Add((string)itemData["projecten"][i]["naam"]); //read in eveything from the database that has the key 'projecten' and the value 'name'
      databaseDescriptions.Add((string)itemData["projecten"][i]["uitleg"]);//read in eveything from the database that has the key 'projecten' and the value 'uitleg'
      databaseIDProjects.Add((string)itemData["projecten"][i]["idProject"]); //read in eveything from the database that has the key 'projecten' and the value 'idProject'
      databaseImages.Add((string)itemData["projecten"][i]["foto"]); //read in eveything from the database that has the key 'projecten' and the value 'foto'
    }
    numberOfProjects = itemData["projecten"].Count; //so the rest of the scripts know how many projects there are
    readyToBuild = true; //so the other scripts know when they can start
  }
 }
