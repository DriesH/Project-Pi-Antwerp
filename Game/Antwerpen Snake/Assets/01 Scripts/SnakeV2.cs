using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class SnakeV2 : TouchLogic {

  private Vector3   fingerPos;            //coördinates of fingertouch
  private Vector3   beginPosSnake;        //to reset the snake to the center position
  private Transform snakeTrans, camTrans; //transform from snake and camera
  private float     speed                 = 10f; //speed of the snake
  private float     maxDist               = 1; //the maximumdistance between snake and finger until it moves again
  private float     resetDelay            = 0.5f;
	
  public GameObject questionPanel         = null; //the panel that alternatively will be set to hide or appear
  
  public static bool       isPlayingGame         = false;// is the game playing or are we answering a question    
  public static string whichFoodwasPickedUp      = ""; //so the next script knows which answer was given


  void Start()
  {
    snakeTrans    = this.transform;           //save startposition and -rotation of the snake
    camTrans      = Camera.main.transform;    // save de startposition and -rotation of the camera
    beginPosSnake = this.transform.position;  //save startposition and -rotation of the snake
  }

  void LookAtFinger() //move and look at fingertouch
  {
    if (isPlayingGame)
    {
      //looks at the touchinput (which only has x and y) and then calculate the position bewteen the snake and camera, to prevent te snake of going towards or away from the camera
      Vector3 tempTouch = new Vector3(Input.GetTouch(touch2Watch).position.x, Input.GetTouch(touch2Watch).position.y,
          camTrans.position.y - snakeTrans.position.y);
      fingerPos = Camera.main.ScreenToWorldPoint(tempTouch); //translates the touchinput from the screen into the world

      snakeTrans.LookAt(fingerPos); //looks at the finger position and rotates to it

      if (Vector3.Distance(fingerPos, snakeTrans.position) > maxDist) //makes sure the snake doesn't bug out weirdly by checking the distance between the finger and the snake
      {
        snakeTrans.Translate(Vector3.forward * speed * Time.deltaTime); //moves the snake towards the touch
      }
    }
  }

  void OnTouchMoved() //if the touch has moved
  { LookAtFinger(); }

  void OnTouchStayed() //if the touch is stationary
  { LookAtFinger(); }

  void OnTouchBegan() //if there is a touch
  {
    touch2Watch = TouchLogic.currTouch; //the currtouch is converted to the touch that the whole script has to look at 
  }

  void OnTouchEnded() //if a touch has ended (needed to be here of unity might give an error)
  { }

  void OnTriggerEnter(Collider c) //als de snake botst tegen iets
  {
    if (c.tag.StartsWith("food"))
    {
      reset();
      isPlayingGame = false;
      questionPanel.SetActive(true);
      whichFoodwasPickedUp = c.tag;
    }
	else if (c.tag.StartsWith("reset"))
    {
        reset();
        StartCoroutine(waitAfterReset());
    }
  }
	
  void reset() { transform.position = beginPosSnake; }//resets snake position
	
  public IEnumerator waitAfterReset(){
      isPlayingGame = false;
      yield return new WaitForSeconds(resetDelay);//waits half a second before game is playable again to prevent possible spastic movements
      isPlayingGame = true;
      
  }
}
