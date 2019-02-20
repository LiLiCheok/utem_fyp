package com.buyme.Interface;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.app.FragmentManager;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    Toolbar toolbar;
    DrawerLayout drawer;
    ActionBarDrawerToggle toggle;
    NavigationView navigationView;
    Menu menu;
    View headerView;
    public static TextView greeting_msg;
    public static TextView greeting_email;
    public static TextView num_cart;
    public static TextView num_order;
    AlertDialog.Builder builder;
    AlertDialog alert;
    SharedPreferences myPrefs;
    SharedPreferences.Editor editor;

    public static String login_id = "";
    public static String login_email = "";
    public static String login_name = "";
    String resultLogin;
    String resultProfile;
    String resultCart;
    String resultOrder;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        navigationView.setItemIconTintList(null);

        menu = navigationView.getMenu();

        // check whether the user still login
        myPrefs = this.getSharedPreferences(WebServiceCall.prefs_login, MODE_WORLD_READABLE);
        login_id= myPrefs.getString(WebServiceCall.prefs_login_id_key, null);
        login_email= myPrefs.getString(WebServiceCall.prefs_login_email_key, null);
        login_name = myPrefs.getString(WebServiceCall.prefs_login_name_key, null);

        headerView = navigationView.getHeaderView(0);
        greeting_msg = (TextView) headerView.findViewById(R.id.greeting_msg);
        greeting_email = (TextView) headerView.findViewById(R.id.greeting_email);
        num_cart = (TextView) navigationView.getMenu().findItem(R.id.nav_cart).getActionView();
        num_order = (TextView) navigationView.getMenu().findItem(R.id.nav_order).getActionView();

        // Navigate to Home page
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            resultLogin = "openLogin";
            resultProfile = "openProfile";
            resultCart = "openCart";
            resultOrder = "openOrder";
            if (resultLogin.equals(extras.getString("openLogin"))) {
                FragmentManager fm_login = getSupportFragmentManager();
                fm_login.beginTransaction().replace(R.id.fragment_container, new LoginFragment()).commit();
                showBackMenu();
            } else {
            }
            if (resultProfile.equals(extras.getString("openProfile"))) {
                FragmentManager fm_profile = getSupportFragmentManager();
                fm_profile.beginTransaction().replace(R.id.fragment_container, new ProfileFragment()).commit();
                showBackMenu();
            } else {
            }
            if (resultCart.equals(extras.getString("openCart"))) {
                FragmentManager fm_profile = getSupportFragmentManager();
                fm_profile.beginTransaction().replace(R.id.fragment_container, new CartFragment()).commit();
                showBackMenu();
            } else {
            }
            if (resultOrder.equals(extras.getString("openOrder"))) {
                FragmentManager fm_profile = getSupportFragmentManager();
                fm_profile.beginTransaction().replace(R.id.fragment_container, new OrderFragment()).commit();
                showBackMenu();
            } else {
            }
        } else {
            FragmentManager fm_home = getSupportFragmentManager();
            fm_home.beginTransaction().replace(R.id.fragment_container, new HomeFragment()).commit();
            showMenu();
        }
    }

    private void showBackMenu() {
        if(login_id==null && login_email==null && login_name==null) {

            menu.findItem(R.id.nav_login).setVisible(true);
            menu.findItem(R.id.nav_register).setVisible(true);
            menu.findItem(R.id.nav_logout).setVisible(false);

        } else {

            greeting_msg.setText("Welcome, "+login_name);
            greeting_email.setText(login_email);

            menu.findItem(R.id.nav_login).setVisible(false);
            menu.findItem(R.id.nav_register).setVisible(false);
            menu.findItem(R.id.nav_cart).setVisible(true);
            menu.findItem(R.id.nav_order).setVisible(true);
            menu.findItem(R.id.nav_profile).setVisible(true);
            menu.findItem(R.id.nav_logout).setVisible(true);
            getCartOrderNum();
        }
    }

    private void showMenu() {
        if(login_id==null && login_email==null && login_name==null) {

            menu.findItem(R.id.nav_login).setVisible(true);
            menu.findItem(R.id.nav_register).setVisible(true);
            menu.findItem(R.id.nav_logout).setVisible(false);

        } else {

            greeting_msg.setText("Welcome, "+login_name);
            greeting_email.setText(login_email);

            Toast.makeText(getApplicationContext(), "Welcome back "+login_name, Toast.LENGTH_LONG).show();
            menu.findItem(R.id.nav_login).setVisible(false);
            menu.findItem(R.id.nav_register).setVisible(false);
            menu.findItem(R.id.nav_cart).setVisible(true);
            menu.findItem(R.id.nav_order).setVisible(true);
            menu.findItem(R.id.nav_profile).setVisible(true);
            menu.findItem(R.id.nav_logout).setVisible(true);
            getCartOrderNum();
        }
    }

    private void getCartOrderNum() {
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetCartOrderNo));
                params1.add(new BasicNameValuePair("user_id", login_id));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    final String cart_num = jsnObj.optString("num_cart");
                    final String order_num = jsnObj.optString("num_order");
                    runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            num_cart.setText(cart_num);
                            num_order.setText(order_num);
                        }
                    });
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetCartOrderNo", "Error!");
                }
            }
        };
        Thread thr = new Thread(run);
        thr.start();
    }

    @Override
    public void onBackPressed() {

        drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            confirmEndApp();
        }
    }

    private void confirmEndApp() {

        builder = new AlertDialog.Builder(MainActivity.this);

        builder.setTitle("Exit Application");
        builder.setMessage("Are you sure you want to close application?");

        builder.setPositiveButton("Yes",new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int which) {
                MainActivity.this.finish();
            }

        });

        builder.setNegativeButton("No",new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });

        alert = builder.create();
        alert.show();
    }

    @Override
    public boolean onCreateOptionsMenu(final Menu category_menu) {

        if(login_id==null && login_email==null && login_name==null) {
            // Show nothing
            return false;
        } else {
            // Inflate the menu; this adds items to the action bar if it is present.
            MenuInflater inflater = getMenuInflater();
            inflater.inflate(R.menu.main, category_menu);
            return true;
        }
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_cart) {
            FragmentManager fm = getSupportFragmentManager();
            fm.beginTransaction().replace(R.id.fragment_container,
                    new CartFragment()).commit();
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {

        FragmentManager fm = getSupportFragmentManager();

        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_home) {

            fm.beginTransaction().replace(R.id.fragment_container,
                    new HomeFragment()).commit();

        } else if (id == R.id.nav_login) {

            fm.beginTransaction().replace(R.id.fragment_container,
                    new LoginFragment()).commit();

        } else if (id == R.id.nav_register) {

            fm.beginTransaction().replace(R.id.fragment_container,
                    new RegisterFragment()).commit();

        } else if (id == R.id.nav_cart) {

            fm.beginTransaction().replace(R.id.fragment_container,
                    new CartFragment()).commit();

        } else if (id == R.id.nav_order) {

            fm.beginTransaction().replace(R.id.fragment_container,
                    new OrderFragment()).commit();

        } else if (id == R.id.nav_profile) {

            fm.beginTransaction().replace(R.id.fragment_container,
                    new ProfileFragment()).commit();

        } else if (id == R.id.nav_logout) {

            confirmLogOut();
        }

        drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    private void confirmLogOut() {

        builder = new AlertDialog.Builder(MainActivity.this);

        builder.setTitle("Sign Out");
        builder.setMessage("Are you sure you want to sign out?");

        builder.setPositiveButton("Yes",new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int which) {

                dialog.cancel();
                greeting_msg.setText("Welcome to BuyMe");
                greeting_email.setText("melaka.buyme2016@gmail.com");

                // Clear user id after logout
                myPrefs = getSharedPreferences(WebServiceCall.prefs_login, Context.MODE_PRIVATE);
                editor = myPrefs.edit();
                editor.remove(WebServiceCall.prefs_login_id_key);
                editor.remove(WebServiceCall.prefs_login_email_key);
                editor.remove(WebServiceCall.prefs_login_name_key);
                editor.commit();

                NavigationView nv;
                nv = (NavigationView) findViewById(R.id.nav_view);
                nv.getMenu().findItem(R.id.nav_login).setVisible(true);
                nv.getMenu().findItem(R.id.nav_register).setVisible(true);
                nv.getMenu().findItem(R.id.nav_cart).setVisible(false);
                nv.getMenu().findItem(R.id.nav_order).setVisible(false);
                nv.getMenu().findItem(R.id.nav_profile).setVisible(false);
                nv.getMenu().findItem(R.id.nav_logout).setVisible(false);

                Toast.makeText(getApplicationContext(), "Logout Successfully.", Toast.LENGTH_LONG).show();

                finish();
                startActivity(getIntent());
            }

        });

        builder.setNegativeButton("No",new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }

        });

        alert = builder.create();
        alert.show();
    }
}
