package com.buyme.Interface;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.Toast;

import com.buyme.Adapter.ProductAdapter;
import com.buyme.DatabaseController.WebServiceCall;
import com.buyme.GetterSetterClass.Product;
import com.buyme.R;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

/**
 * A simple {@link Fragment} subclass.
 */
public class HomeFragment extends Fragment implements AdapterView.OnItemSelectedListener {

    static FragmentManager fm;
    static AlertDialog.Builder builder;
    static AlertDialog alert;

    View v;
    Spinner spinner;
    String status;
    static String category_name = null;

    ArrayList<String> categories;
    ArrayAdapter adapter;

    ListView list;
    ArrayList<Product> products;
    ProductAdapter padapter;
    Product product;

    WebServiceCall wsc = new WebServiceCall();
    JSONObject jsnObj = new JSONObject();

    public HomeFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        getActivity().setTitle("BuyMe");
        fm = getActivity().getSupportFragmentManager();
        builder = new AlertDialog.Builder(getActivity());

        // Inflate the layout for this fragment
        v = inflater.inflate(R.layout.fragment_home, container, false);

        spinner = (Spinner) v.findViewById(R.id.spinner);
        categories = new ArrayList<String>();
        adapter = new ArrayAdapter(getActivity(), android.R.layout.simple_dropdown_item_1line, categories);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        getCategories();

        list = (ListView) v.findViewById(R.id.list);
        products = new ArrayList<Product>();

        spinner.setOnItemSelectedListener(this);

        return v;
    }

    /**
     * Get all the categories created by admin
     */
    public void getCategories() {
        status = "active";
        Runnable run = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params1 = new ArrayList<NameValuePair>();
                params1.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetCategory));
                params1.add(new BasicNameValuePair("status", status));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params1);
                    JSONArray data = jsnObj.getJSONArray("data");
                    for(int index=0; index<data.length(); index++) {
                        JSONObject obj = data.getJSONObject(index);
                        categories.add(obj.optString("category_name").trim());
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetCategory", "Error!");
                }
                getActivity().runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        spinner.setAdapter(adapter);
                    }
                });
            }
        };
        Thread thread = new Thread(run);
        thread.start();
    }

    /**
     * For ProfileFragment
     */
    public static final void openProfileFrag() {

        fm.beginTransaction().replace(R.id.fragment_container,
                new ProfileFragment()).commit();
    }

    /**
     * For ProductAdapter and SpecificProductFragment
     */
    public static final void openLoginMsg() {
        builder.setTitle("Login?");
        builder.setMessage("You may need to login for ordering process.");
        builder.setPositiveButton("Login Now",new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                openLoginFrag();
            }
        });
        builder.setNegativeButton("Cancel",new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });
        alert = builder.create();
        alert.show();
    }

    public static final void openLoginFrag() {

        fm.beginTransaction().replace(R.id.fragment_container,
                new LoginFragment()).commit();
    }

    /**
     * Product is displayed according to the categories
     * @param adapterView
     * @param view
     * @param i
     * @param l
     */
    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
        category_name = String.valueOf(adapterView.getItemAtPosition(i));
        if (products.size() > 0) {
            getActivity().runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    padapter.clear();
                    list.setAdapter(null);
                    if(list.getAdapter()==null) {
                        show_product();
                    }
                }
            });
        } else {
            show_product();
//            final Runnable runnable = new Runnable() {
//                @Override
//                public void run() {
//                    final List<NameValuePair> params = new ArrayList<NameValuePair>();
//                    params.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetProduct));
//                    params.add(new BasicNameValuePair("category_name", category_name));
//                    try {
//                        jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params);
//                        JSONArray data = jsnObj.getJSONArray("data");
//                        if(data.length()==0) {
//                            getActivity().runOnUiThread(new Runnable() {
//                                @Override
//                                public void run() {
//                                    Toast.makeText(getActivity(), "Currently no products for the selected category.", Toast.LENGTH_LONG).show();
//                                }
//                            });
//                        } else {
//                            for (int index = 0; index < data.length(); index++) {
//                                product = new Product();
//                                JSONObject obj = data.getJSONObject(index);
//                                product.setProductID(obj.optString("product_id"));
//                                product.setProductName(obj.optString("product_name"));
//                                final String encodedString1 = obj.getString("product_image");
//                                final String pureBase64Encoded1 =
//                                        encodedString1.substring(encodedString1.indexOf(",") + 1);
//                                final byte[] decodedBytes1 =
//                                        Base64.decode(pureBase64Encoded1, Base64.DEFAULT);
//                                Bitmap decodedBitmap1 =
//                                        BitmapFactory.decodeByteArray(decodedBytes1, 0, decodedBytes1.length);
//                                int h1 = 300; // height in pixels
//                                int w1 = 300; // width in pixels
//                                Bitmap photoBitMap1 = Bitmap.createScaledBitmap(decodedBitmap1, h1, w1, true);
//                                product.setProductImage(photoBitMap1);
//                                product.setProductPrice(obj.optString("product_price"));
//                                product.setShopName(obj.optString("shop_name"));
//                                products.add(product);
//                            }
//                            getActivity().runOnUiThread(new Runnable() {
//                                @Override
//                                public void run() {
//                                    padapter = new ProductAdapter(getActivity(), getActivity().getApplicationContext(), R.layout.product_list, products);
//                                    list.setAdapter(padapter);
//                                    list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
//                                        @Override
//                                        public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
//                                            Fragment newFragment = new SpecificProductFragment();
//                                            FragmentTransaction transaction = getActivity().getSupportFragmentManager().beginTransaction();
//                                            Bundle args = new Bundle();
//                                            args.putString("product_id", products.get(i).getProductID());
//                                            newFragment.setArguments(args);
//                                            transaction.replace(R.id.fragment_container, newFragment);
//                                            transaction.addToBackStack(null);
//                                            transaction.commit();
//                                        }
//                                    });
//                                    padapter.notifyDataSetChanged();
//                                }
//                            });
//                        }
//                    } catch (Exception e) {
//                        e.printStackTrace();
//                        Log.d("GetProduct", "Error!");
//                    }
//                }
//            };
//            Thread thread = new Thread(runnable);
//            thread.start();
        }
    }

    private void show_product() {
        final Runnable runnable = new Runnable() {
            @Override
            public void run() {
                final List<NameValuePair> params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair(WebServiceCall.FN, WebServiceCall.fnGetProduct));
                params.add(new BasicNameValuePair("category_name", category_name));
                try {
                    jsnObj = wsc.makeHttpRequest(wsc.getURL(), WebServiceCall.REQUEST_METHOD, params);
                    JSONArray data = jsnObj.getJSONArray("data");
                    if(data.length()==0) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(getActivity(), "Currently no products for the selected category.", Toast.LENGTH_LONG).show();
                            }
                        });
                    } else {
                        for (int index = 0; index < data.length(); index++) {
                            product = new Product();
                            JSONObject obj = data.getJSONObject(index);
                            product.setProductID(obj.optString("product_id"));
                            product.setProductName(obj.optString("product_name"));
                            final String encodedString1 = obj.getString("product_image");
                            final String pureBase64Encoded1 =
                                    encodedString1.substring(encodedString1.indexOf(",") + 1);
                            final byte[] decodedBytes1 =
                                    Base64.decode(pureBase64Encoded1, Base64.DEFAULT);
                            Bitmap decodedBitmap1 =
                                    BitmapFactory.decodeByteArray(decodedBytes1, 0, decodedBytes1.length);
                            int h1 = 300; // height in pixels
                            int w1 = 300; // width in pixels
                            Bitmap photoBitMap1 = Bitmap.createScaledBitmap(decodedBitmap1, h1, w1, true);
                            product.setProductImage(photoBitMap1);
                            product.setProductPrice(obj.optString("product_price"));
                            product.setShopName(obj.optString("shop_name"));
                            products.add(product);
                        }
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                padapter = new ProductAdapter(getActivity(), getActivity().getApplicationContext(), R.layout.product_list, products);
                                list.setAdapter(padapter);
                                list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                                    @Override
                                    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                                        Fragment newFragment = new SpecificProductFragment();
                                        FragmentTransaction transaction = getActivity().getSupportFragmentManager().beginTransaction();
                                        Bundle args = new Bundle();
                                        args.putString("product_id", products.get(i).getProductID());
                                        newFragment.setArguments(args);
                                        transaction.replace(R.id.fragment_container, newFragment);
                                        transaction.addToBackStack(null);
                                        transaction.commit();
                                    }
                                });
                                padapter.notifyDataSetChanged();
                            }
                        });
                    }
                } catch (Exception e) {
                    e.printStackTrace();
                    Log.d("GetProduct", "Error!");
                }
            }
        };
        Thread thread = new Thread(runnable);
        thread.start();
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }
}
