using UnityEngine;
using System.Collections;

public class TouchLogic : MonoBehaviour //contains all touch logic
{
  public static int currTouch = 0; //is needed for other scripts, so they know which touch is active
  public int touch2Watch      = 0; //other script know at which touch they have to look

  void Update()
  {
    //is there a touch?
    if (Input.touches.Length <= 0)
    {
      //if there is no touch
    }
    else //if there is a touch
    {
      //there is no foreach since the snake only needs to react to 1 touch ==> all the other touches will be ignored
      if (Input.GetTouch(0).phase == TouchPhase.Began) //if a touch began
      {
        this.SendMessage("OnTouchBegan"); //send a message which executes "OnTouchBegan"
      }
      if (Input.GetTouch(0).phase == TouchPhase.Ended) //if a touch ended
      {
        this.SendMessage("OnTouchEnded"); //send a message which executes "OnTouchEnded" 
      }
      if (Input.GetTouch(0).phase == TouchPhase.Moved) //if a touch moved
      {
        this.SendMessage("OnTouchMoved"); //send a message which executes "OnTouchMoved"
      }
      if (Input.GetTouch(0).phase == TouchPhase.Stationary) //is a touch is stationary
      {
        this.SendMessage("OnTouchStayed"); //send a message which executes "OnTouchStayed" 
      }
    }
  }
}
