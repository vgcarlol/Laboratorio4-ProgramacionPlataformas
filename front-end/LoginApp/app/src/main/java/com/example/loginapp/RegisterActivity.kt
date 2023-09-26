package com.example.loginapp

import android.content.Context
import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext
import okhttp3.MediaType.Companion.toMediaType
import okhttp3.OkHttpClient
import okhttp3.Request
import okhttp3.RequestBody.Companion.toRequestBody
import org.json.JSONObject

class RegisterActivity : AppCompatActivity() {

    private lateinit var etRegisterUsername: EditText
    private lateinit var etRegisterPassword: EditText
    private lateinit var btnRegister: Button
    private lateinit var tvGoToLogin: TextView  // <-- Añade esta línea

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_register)

        etRegisterUsername = findViewById(R.id.etRegisterUsername)
        etRegisterPassword = findViewById(R.id.etRegisterPassword)
        btnRegister = findViewById(R.id.btnRegister)
        tvGoToLogin = findViewById(R.id.tvGoToLogin)  // <-- Añade esta línea

        btnRegister.setOnClickListener {
            val username = etRegisterUsername.text.toString()
            val password = etRegisterPassword.text.toString()

            GlobalScope.launch(Dispatchers.Main) {
                val success = registerUser(applicationContext, username, password)
                if (success) {
                    Toast.makeText(applicationContext, "Registration successful", Toast.LENGTH_SHORT).show()
                    finish()
                } else {
                    Toast.makeText(applicationContext, "Registration failed", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }

    suspend fun registerUser(context: Context, username: String, password: String): Boolean {
        val json = JSONObject()
        json.put("username", username)
        json.put("password", password)

        val mediaType = "application/x-www-form-urlencoded; charset=UTF-8".toMediaType()
        val requestBody = json.toString().toRequestBody(mediaType)

        val request = Request.Builder()
            .url("http://10.0.2.2/backend-login/register.php") // Reemplaza con la URL de tu servidor de registro
            .post(requestBody)
            .build()

        return withContext(Dispatchers.IO) {
            val response = OkHttpClient().newCall(request).execute()
            val responseBody = response.body?.string()
            response.isSuccessful && responseBody != null && responseBody == "success"
        }
    }
}
