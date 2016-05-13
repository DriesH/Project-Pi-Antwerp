using UnityEngine;
using System;
using System.Collections;
using System.Data;
using MySql.Data.MySqlClient;
using UnityEngine.UI;
using System.Collections.Generic;

public class DatabaseLogic: MonoBehaviour
{
 //werkt momenteel enkel met 1 titel en 1 descr, mssn list gebruiken?

  private static IDbConnection dbConnection; //the connection with the database
  private static string connectionString; //the string to which database has to be connected

  protected static List<String> databaseTitles = new List<String>(); //titels of the projects that need to be loaded from the database
  protected static List<String> databaseDescriptions = new List<String>(); //descriptions of the projects that need to be loaded from the database
  protected static List<String> databaseImages = new List<String>(); //images of the projects that need to be loaded from the database (saven in longtext in database)

  protected static int numberOfProjects = 0; //the number of total projects

  public void StartDatabase()
  {
    openSqlConnection();

    if (connectionString != null)
    {
      doQuery("SELECT naam, uitleg, idProject, foto FROM projects ORDER BY idCategorie ASC;");
    }
  }

  void OnApplicationQuit() //when app is closed, close connection with database
  {
    closeSqlConnection();
  }

  // Connect to database
  static void openSqlConnection()
  {
  /* for Local
   * connectionString = "Server=localhost;" +
        "Database=mydb;" +
        "User ID=root;" +
        "Password=;" +
        "Pooling=true";*/

  //for database online
   connectionString = "Server=websites.kdg.be;" +
    "Database=project_antwerpen;" +
    "User ID=joren;" +
    "Password=KdGqDDZ5;" +
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
      //databaseImages[0]     =  van string naar foto doen opt moment
      databaseTitles.Add((String)reader["naam"]); //reads the database titles and puts them in the lst
      databaseDescriptions.Add((String)reader["uitleg"]);
      databaseImages.Add((String)reader["foto"]);
    }
    numberOfProjects = databaseTitles.Count;

    reader.Close(); //always close the reader
    reader = null; //then empty it
    dbCommand.Dispose(); //get rid of the current searchquery
    dbCommand = null; //then empty is
  }
}


