using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;
using System.Collections.Generic;

public class ReadJson : MonoBehaviour {
  
  private string jsonString;
  private JsonData itemData;
  private string urlString = "http://pi.multimediatechnology.be.be/API/get/projecten";

  protected List<string> databaseTitles       = new List<string>(); //titels of the projects that need to be loaded from the database
  protected List<string> databaseDescriptions = new List<string>(); //descriptions of the projects that need to be loaded from the database
  protected List<string> databaseImages       = new List<string>(); //images of the projects that need to be loaded from the database (saven in longtext in database)
  protected List<int>    databaseIDProjects   = new List<int>();

  protected int numberOfProjects = 0; //the number of total projects

	void Start () {
    getUrl(urlString);

    jsonString = File.ReadAllText(Application.dataPath + "/06 Resources/testjson.json"); //url hier nog plaatsen (anders?) opt moment leest hij uit folder
//    Debug.Log(jsonString);

    itemData = JsonMapper.ToObject(jsonString); //parse it into a JsonObject

    Debug.Log(itemData["Projects"][0]["naam"]); //in de Json projecten, dan welke key (of pos hier eerste project) en geef naam
   // Debug.Log(itemData["Projects"][1]["naam"]); 
    Debug.Log(itemData["Projects"][0]["uitleg"]);
    Debug.Log(itemData["Projects"][0]["idProject"]);
    Debug.Log(itemData["Projects"][0]["foto"]);


    // ==> hoe in lijst steken?

//    Debug.Log(GetItem("Projects", "Vuilbak")); //naam project ==> dit is enkel zoeken

   // numberOfProjects = itemData["Projects"].Count; //so the rest of the scripts know how many projects there are
	}
	
  JsonData GetItem(string category, string name) //search name in category and return it
  {
    for (int i = 0; i < itemData[category].Count; i++)
    {
      if (itemData[category][i]["naam"].ToString() == name)
      {
        return itemData[category][i];
      }
    }
    return null; //if nothing was found
  }

  IEnumerator getUrl(string url)
  {
    WWW www = new WWW(url);      // Start a download of the given URL
    yield return www.text;      // Wait for download to complete

    Debug.Log(www.text);

    //de rest hierachter steken?
   }
 }
