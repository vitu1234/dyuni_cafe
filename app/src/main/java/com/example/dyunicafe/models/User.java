package com.example.dyunicafe.models;

public class User {

    private int user_id,account_status;
    private String fullname, email, phone,user_role,account_balance;

    public User(int user_id, int account_status, String fullname, String email, String phone, String user_role, String account_balance) {
        this.user_id = user_id;
        this.account_status = account_status;
        this.fullname = fullname;
        this.email = email;
        this.phone = phone;
        this.user_role = user_role;
        this.account_balance = account_balance;
    }

    public int getUser_id() {
        return user_id;
    }

    public int getAccount_status() {
        return account_status;
    }

    public String getFullname() {
        return fullname;
    }

    public String getEmail() {
        return email;
    }

    public String getPhone() {
        return phone;
    }

    public String getUser_role() {
        return user_role;
    }

    public String getAccount_balance() {
        return account_balance;
    }
}
