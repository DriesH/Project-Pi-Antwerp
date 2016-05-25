using UnityEngine;
using System.Collections;

public class Navbar : MonoBehaviour {

	public Texture2D buttonHome     = null;         //texture for HomeButton (A-logo)
	public Texture2D buttonWeb      = null;         //texture for WebButton (computer)
	public Texture2D buttonGame     = null;         //texture for gameButton (gamepad)
	private int screenWidth         = Screen.width; //load in screenwidth 
	private float iconSize          = 0;            //standardsize of icons
  private float firstIconPos      = 0;            //position of the first icon
  private float secondIconPos     = 0;            //position of the second icon

	void Start () {
		iconSize = screenWidth * 0.11f; //make de icons spread over de navbar
    firstIconPos = screenWidth * 0.70f;
    secondIconPos = screenWidth * 0.85f;
	}
	
	private void OnGUI() //GUIStyle.none to delete the border around the buttons
	{
			if (GUI.Button(new Rect(0, 0, iconSize, iconSize), buttonHome, GUIStyle.none)) //when pressed on logo, go to the list of projects
			{
				Application.LoadLevel("ListOfProjects");
			}
			if (GUI.Button(new Rect(firstIconPos, 0, iconSize, iconSize), buttonGame, GUIStyle.none)) //when pressed on gamepad icon, go to the startupMenu of the game
			{
				Application.LoadLevel("MainScreenSnake");
			}

			if (GUI.Button(new Rect(secondIconPos, 0, iconSize, iconSize), buttonWeb, GUIStyle.none)) //when pressed on computer icon, go to the website of the projects
      {
				Application.OpenURL("http://pi.multimediatechnology.be/");
			}
	}
}
