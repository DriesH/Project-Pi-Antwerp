using UnityEngine;
using System;
using System.Collections;
using System.Data;
using MySql.Data.MySqlClient;
using UnityEngine.UI;

public class DatabaseLogic: MonoBehaviour
{
 //werkt momenteel enkel met 1 titel en 1 descr, mssn list gebruiken?
  private static IDbConnection dbConnection; //the connection with the database
  private static string connectionString; //the string to which database has to be connected

  protected static String[] databaseTitels; //titels of the projects that need to be loaded from the database
  protected static Image[] databaseImages; //images of the projects that need to be loaded from the database
  protected static String[] databaseDescriptions; //descriptions of the projects that need to be loaded from the database

  protected static int numberOfProjects = 0; //the number of total projects

  public void StartDatabase()
  {
    openSqlConnection();
    databaseTitels       = new String[20];
    databaseImages       = new Image[20];
    databaseDescriptions = new String[20];

    if (connectionString != null)
    { 
    doQuery("SELECT naam, uitleg, foto FROM projects;");
    }
  }

  // On quit
  void OnApplicationQuit() //when app is closed, close connection with database
  {
    closeSqlConnection();
  }

  // Connect to database
  static void openSqlConnection()
  {
   connectionString = "Server=localhost;" +
        "Database=mydb;" +
        "User ID=root;" +
        "Password=;" +
        "Pooling=true";
    dbConnection = new MySqlConnection(connectionString); //make a new connection with the chosen string
    dbConnection.Open(); //open the connection
    //Debug.Log("Connected to database.");
  }

  // Disconnect from database
  static void closeSqlConnection()
  {
    if (dbConnection != null)
    { 
      dbConnection.Close();
      dbConnection = null;
     // Debug.Log("Disconnected from database.");
    }
  }

  // MySQL Query
  public static void doQuery(string sqlQuery)
  {
    IDbCommand dbCommand = dbConnection.CreateCommand();
    dbCommand.CommandText = sqlQuery;
    IDataReader reader = dbCommand.ExecuteReader();

    while (reader.Read())
    {
      databaseTitels[0]= (String)reader["naam"];
      databaseDescriptions[0] = (String)reader["uitleg"];
      //databaseImages[0] =  van string naar foto doen opt moment
    }

    foreach (string titel in databaseTitels)
    {
      if (titel != null)
      {
        numberOfProjects++;
      }
    }
    Debug.Log(numberOfProjects);
    reader.Close(); //always close the reader
    reader = null; //then empty it
    dbCommand.Dispose(); //get rid of the current searchquery
    dbCommand = null; //then empty is
  }
}


