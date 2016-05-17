using UnityEngine;
using System.Collections;
using System.IO;
using LitJson;

public class WriteJson : MonoBehaviour {

  public QuestionData qData = new QuestionData("Vuilbakken op bomen zijn nodig.", "Helemaal eens", "eens", "oneens", "helemaal oneens");
  JsonData answerData;

	void Start () {
    answerData = JsonMapper.ToJson(qData);
    File.WriteAllText(Application.dataPath + "/06 Resources/testJson.json", answerData.ToString());
	}

}

public class QuestionData {
  public string question;
  public string answer1;
  public string answer2;
  public string answer3;
  public string answer4;

  public QuestionData (string question, string answer1, string answer2, string answer3, string answer4) {
    this.question = question;
    this.answer1 = answer1;
    this.answer2 = answer2;
    this.answer3 = answer3;
    this.answer4 = answer4;
  }
}