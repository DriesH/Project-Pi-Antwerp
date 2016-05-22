using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class SnakeV2 : TouchLogic {

  private Vector3 fingerPos; //coördinates of fingertouch
  private Transform snakeTrans, camTrans; //transform from snake and camera
  private float speed = 10f; //speed of the snake
  private Vector3 beginPosSnake; //to reset the snake to the center position
  private float maxDist = 1; //the maximumdistance between snake and finger until it moves again

  public GameObject food = null;
  public bool isPlayingGame; // is the game playing or are we answering a question

  public GameObject questionPanel = null; //drag UI questionpanel to the inspector

  void Start()
  {
    snakeTrans = this.transform; //save startposition and -rotation of the snake
    camTrans = Camera.main.transform; // save de startposition and -rotation of the camera
    beginPosSnake = this.transform.position; //save startposition and -rotation of the snake
    isPlayingGame = false;

    for (int i = 1; i <= 4; i++)
    {
      SpawnPickup("food_" + i);
    }
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
  { touch2Watch = TouchLogic.currTouch; //the currtouch is converted to the touch that the whole script has to look at 
  }

  void OnTouchEnded() //if a touch has ended (needed to be here of unity might give an error)
  { }

  void SpawnPickup(string number) //spawnt in 4 corners
  {
      switch (number)
      { 
        case "food_1":
          food.tag = "food_1"; //give the object the following tag
          Instantiate(food, new Vector3(-4.63f, 0.5f, 6.51f), Quaternion.identity); //upper left position
          break;
        case "food_2":
          food.tag = "food_2";
          Instantiate(food, new Vector3(4.63f, 0.5f, 6.51f), Quaternion.identity); //upper right position
          break;
        case "food_3":
          food.tag = "food_3";
          Instantiate(food, new Vector3(-4.63f, 0.5f, -8.11f), Quaternion.identity); //lower left position
          break;
        case "food_4":
          food.tag = "food_4";
          Instantiate(food, new Vector3(4.63f, 0.5f, -8.11f), Quaternion.identity); //lower right position
          break;
      }
  }

  void OnTriggerEnter(Collider c) //als de snake botst tegen iets
  {
    if (c.tag.StartsWith("food"))
    {
      transform.position = beginPosSnake; //test zet snake op begin
      isPlayingGame = false;
      questionPanel.SetActive(true);
    }
    else if (c.tag.StartsWith("respawn")) // respawn when player oved to the middle
    {
      SpawnPickup("food_1");
      SpawnPickup("food_2");
      SpawnPickup("food_3");
      SpawnPickup("food_4");
    }
  }
}
