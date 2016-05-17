using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;

public class ReadJson : MonoBehaviour {
  
  private string jsonString;
  private JsonData itemData;
  private string urlString;

	void Start () {
    //urlString = getUrl();  ==> uuhhh....
    
    //jsonString = File.ReadAllText(Application.dataPath + "06 Resources/Projects.json"); //url hier nog plaatsen (anders?) opt moment leest hij uit folder
    
    jsonString = File.ReadAllText(urlString); //read all data in the file
    itemData = JsonMapper.ToObject(jsonString); //parse it into a JsonObject

    Debug.Log(itemData["project"][1]["bvNaam"]); //eerst project aanduiden, dan zeggen welke ID, dan hetgeen dat je nodig hebt (bv naam)
    Debug.Log(GetItem("Lorem ipsum", "project")["image"]); //zeg wel projectnaam je wilt, en in welke categorie
	}
	
  JsonData GetItem(string name, string category) //search name in category and return it
  {
    for (int i = 0; i < itemData[category].Count; i++)
    {
      if (itemData[category][i]["name"].ToString() == name)
      {
        return itemData[category][i];
      }
    }
    return null; //if nothing was found
  }

  IEnumerator getUrl()
  {
      string JsonUrl = "http://pi.multimediatechnology.be"; // /json????

      // Start a download of the given URL
      WWW www = new WWW(JsonUrl);

      // Wait for download to complete
      yield return www.text;
   }
 }
