package com.example.messegeisland

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.compose.foundation.layout.Column
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.material3.MaterialTheme
import androidx.compose.material3.Surface
import androidx.compose.material3.Text
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import com.example.messegeisland.ui.theme.MessegeIslandTheme

class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        val dbHelper = MyDBHelper(this)
        dbHelper.insertMessage("Условный текст в SQL")
        dbHelper.insertMessage("Шалом гои.")
        dbHelper.insertMessage("Удалить текст")
        val messages = dbHelper.getAllMessages()

        setContent {
            MessegeIslandTheme {
                Surface(
                    modifier = Modifier.fillMaxSize(),
                    color = MaterialTheme.colorScheme.background
                ) {
                    MessageList(messages)
                }
            }
        }
    }
}

@Composable
fun MessageList(messages: List<String>) {
    Column {
        for (message in messages) {
            Text(text = message)
        }
    }
}

@Composable
fun Greeting(name: String, modifier: Modifier = Modifier) {
    Text(
        text = "Hello $name!",
        modifier = modifier
    )
}

@Preview(showBackground = true)
@Composable
fun GreetingPreview() {
    MessegeIslandTheme {
        Greeting("Android")
    }
}

