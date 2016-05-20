using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;
using System.Collections.Generic;

public class ReadJson : MonoBehaviour {
  
  private string jsonString; //the string read from the Json api from the website
  private JsonData itemData; //the data that will be used to select the data needed from the json file
  private string urlString = "http://pi.multimediatechnology.be.be/API/get/projecten"; //the url where to find the json file

  protected static List<string> databaseTitles       = new List<string>(); //titels of the projects that need to be loaded from the database
  protected static List<string> databaseDescriptions = new List<string>(); //descriptions of the projects that need to be loaded from the database
  protected static List<string> databaseImages       = new List<string>(); //images of the projects that need to be loaded from the database (saven in longtext in database)
  protected static List<string> databaseIDProjects   = new List<string>(); //the id of the projects that need to be loaded from the database to follow the URL (in string since it has to be a string later on anyway)

  protected static int numberOfProjects = 0; //the number of total projects

	void Start () {
    GetUrl(urlString);

    jsonString = File.ReadAllText(Application.dataPath + "/06 Resources/testjson.json"); //url hier nog plaatsen (anders?) opt moment leest hij uit folder
//    Debug.Log(jsonString);

    itemData = JsonMapper.ToObject(jsonString); //parse it into a JsonObject

    Debug.Log(itemData["Projecten"][0]["naam"]); //in de Json projecten, dan welke key (of pos hier eerste project) en geef naam
    // Debug.Log(itemData["Projecten"][1]["naam"]); 
    Debug.Log(itemData["Projecten"][0]["uitleg"]);
    Debug.Log(itemData["Projecten"][0]["idProject"]);
    Debug.Log(itemData["Projecten"][0]["foto"]);

    try
    {
      for (int i = 0; i < itemData["Projecten"].Count; i++)
      {
        databaseTitles.Add((string)itemData["Projecten"][i]["naam"]);
        databaseDescriptions.Add((string)itemData["Projecten"][i]["uitleg"]);
        //databaseImages.Add((string)itemData["Projecten"][i]["foto"]);
        databaseIDProjects.Add((string)itemData["Projecten"][0]["idProject"]); 
      }
      numberOfProjects = itemData["Projecten"].Count; //so the rest of the scripts know how many projects there are
    }
    catch
    {
      numberOfProjects = 0;
    }
	}
	

  IEnumerator GetUrl(string url)
  {
    WWW www = new WWW(url);      // Start a download of the given URL
    yield return www.text;      // Wait for download to complete

    Debug.Log(www.text);

    //de rest hierachter steken?
   }
 }
