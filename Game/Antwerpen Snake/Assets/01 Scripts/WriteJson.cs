using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.IO;
//using LitJson;

public class WriteJson : MonoBehaviour {
  
  private string writeURL = "";
  private Dictionary<string, string> answers = new Dictionary<string, string>();

	void Start () {
    answers.Add("Question1", "AnswerA");

    StartCoroutine(writeToFile());
	}

  IEnumerator writeToFile () { //Ienum wacht op de yield, wa hier gwn de data ophalen is (is standaard)
    WWWForm form = new WWWForm();
    foreach (KeyValuePair<string, string> post_arg in answers)
    {
      form.AddField(post_arg.Key, post_arg.Value); //stopt dictionary in een form
    }
    WWW www = new WWW(writeURL, form); //stuurt form naar URL
    yield return www;

 

    File.WriteAllText(Application.dataPath + "/06 Resources/writeJson.json", www.text);
    File.WriteAllText(Application.dataPath + "/06 Resources/writeJson.json", form.data[0].ToString());
    Debug.Log("File written");
  }

}

//postdata: A byte array of data to be posted to the url. => zelfde data als form
//headers 	A dictionary that contains the header keys and values to pass to the server.s
//  vb van url voor POSTEN : http://pi.multimediatechnology.be/API/post?antwoord=Juist&?user=1?&project=1