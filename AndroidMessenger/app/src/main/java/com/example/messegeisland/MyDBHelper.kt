package com.example.messegeisland

import android.content.ContentValues
import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class MyDBHelper(context: Context) : SQLiteOpenHelper(context, DATABASE_NAME, null, DATABASE_VERSION) {

    companion object {
        private const val DATABASE_NAME = "MessageIslandDB"
        private const val DATABASE_VERSION = 1
        private const val TABLE_NAME = "Messages"
        private const val COLUMN_ID = "_id"
        private const val COLUMN_MESSAGE = "message"
    }

    override fun onCreate(db: SQLiteDatabase) {
        val createTableQuery = "CREATE TABLE $TABLE_NAME ($COLUMN_ID INTEGER PRIMARY KEY, $COLUMN_MESSAGE TEXT)"
        db.execSQL(createTableQuery)
    }

    override fun onUpgrade(db: SQLiteDatabase, oldVersion: Int, newVersion: Int) {
        db.execSQL("DROP TABLE IF EXISTS $TABLE_NAME")
        onCreate(db)
    }

    fun insertMessage(message: String) {
        val db = writableDatabase
        val values = ContentValues().apply {
            put(COLUMN_MESSAGE, message)
        }
        db.insert(TABLE_NAME, null, values)
        db.close()
    }

    fun getAllMessages(): ArrayList<String> {
        val messages = ArrayList<String>()
        val db = readableDatabase
        val cursor = db.rawQuery("SELECT * FROM $TABLE_NAME", null)
        if (cursor.moveToFirst()) {
            do {
                val message = cursor.getString(cursor.getColumnIndex(COLUMN_MESSAGE))
                messages.add(message)
            } while (cursor.moveToNext())
        }
        cursor.close()
        db.close()
        return messages
    }
}

