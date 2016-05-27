using UnityEngine;
using System.Collections;

public class enemyMoving : MonoBehaviour {
  private Vector3 upperLeft = new Vector3(-3.55f, 0.6725f, 3.15f);
  private Vector3 upperRight = new Vector3(3.55f, 0.6725f, 3.15f);
  private Vector3 lowerLeft = new Vector3(-3.55f, 0.6725f, -4.56f);
  private Vector3 lowerRight = new Vector3(3.55f, 0.6725f, -4.56f);
  private Vector3 enemyPos;
  private Vector3 lastDirection;
  private int speed = 2;

  void Start()
  {
    if (this.tag == "reset_1")
    {
      lastDirection = lowerRight;
    }
    
    if (this.tag == "reset_2")
    {
      lastDirection = upperLeft;
    }
 
  }

	void Update () {
    enemyPos = transform.position;

    if (enemyPos == upperLeft)
    {
      lastDirection = upperRight;
    }
    else if (enemyPos == upperRight)
    {
      lastDirection = lowerRight;
    }
    else if (enemyPos == lowerRight)
    {
      lastDirection = lowerLeft;
    }
    else if (enemyPos == lowerLeft)
    {
      lastDirection = upperLeft;
    }
    transform.position = Vector3.MoveTowards(transform.position, lastDirection, speed* Time.deltaTime);
	}
}
