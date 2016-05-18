using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using UnityEngine.UI;

public class FollowProjectURL : DatabaseLogic {

  private Object[] allButtons; //to gather all the buttons in the list
  private Object[] oddButtons; //to gather the "Meer lezen" buttons
  private int j = 0;
  private int IDprojectNumber = 0; //store the IDnumber of the project for the URL
  private Object clickedButton = null; //to see on which button has been clicked

  private static bool IsOdd(int value) //check if the button is odd or zero ('meer lezen' and not 'geef mening')
  {
    return value % 2 != 0 || value == 0;
  }

  public void URLbuttonClicked()
  {
    oddButtons = new Object[numberOfProjects+1]; //to build in a safety
    allButtons = new Object[numberOfProjects*2]; //2 buttons per panel

    allButtons = Resources.FindObjectsOfTypeAll(typeof(Button)); //get everything in the scene that's a button

    for (int i = 0; i < allButtons.GetUpperBound(0); i++)
    {
      if (IsOdd(i)) ///if the button is odd (meer lezen)
      {
        oddButtons[j] = allButtons[i]; //add it to the the oddButtons and raise the arrayposition
        j++;
      }
    }
    clickedButton = this.GetComponent<Button>(); //get component of the button that's clicked
    System.Array.Reverse(oddButtons); //reverse the array 

    for (int i = 0; i < oddButtons.GetUpperBound(0); i++)
    {
      if (clickedButton == oddButtons[i]) //if the clicked button equals a button in the array
      {
        IDprojectNumber = i;
      }
    }

    Application.OpenURL("http://pi.multimediatechnology.be/project/" + databaseIDProjects[IDprojectNumber]);
  }
}
