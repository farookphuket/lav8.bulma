# lav8.bulma

## start on date 22 Nov 2021
> I know a little bit of laravel and I use laravel8 for my web app project but this project will be my first time that I will focus on a single page app
> this is the project laravel8 use bulma vue vue-router jodit-vue moment vue-cookies  






[lav8-bulma-1]:https://i.ibb.co/znGF6Sb/lav8-bulma-1.png
!["the first image from new project"][lav8-bulma-1]




## ================= date 25 Nov 2021 

> fixed footer position to be absolute bottom.

> code in the file `app.css`

```

@media screen and (min-width: 300px), print {

    .section {
      padding: 3rem 1.5rem;
      margin-bottom:140px;
    }
}

```

> code in the file `custom_css.css`


```

html {
    position: relative;
    min-height: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: scroll;
}
body {
    /*background: rgb(230, 230, 220); */
    overflow-x: hidden;
    margin: 0px;
    position: relative;
    min-height: 100%;
    height: auto;
    
}


footer {
 position: absolute;
 margin-top:10px;
 bottom: 0;
 width: 100%;
}



```



## ================= date 24 Nov 2021

> today create edit profile member 
> make prefix route for member use `sanctum` to handle user and use `vue-cookies` 
> for front-end request.
> the token will be re-generate for every user session and will be destroy as user
> logout

```
/* make a route prefix for member group */
Route::prefix("member")->name("member.")->middleware('auth:sanctum')
                                        ->group(function(){

    /* ============= member profile 24 Nov 2021 ====================
     * 
     * */                                        
    Route::resource('/profile',MPF::class);
    Route::post('/check-confirm-key',[MPF::class,'checkConfirmKey'])
        ->name('check-member-profile-confirm-key');

    /* Logout from member */
    Route::delete('/logout',[Login::class,'destroy'])->name('logout');

      });
```

> try to update user profile to make sure that the `name`,`email` will be unique
> code in the controller

```
$valid = request()->validate([
    "name" => ["required","unique:users,name,".Auth::user()->id],
    "email" => ["required","email","unique:users,email,".Auth::user()->id]
],
[
    "name.unique" => "Error : cannot use this name",
    "email.unique" => "Error : cannot use this email",
]);

```

> to validate the password with Hash the first argument will be plain text 
> and the secound argument will the hash password version from DB.

> to hash the password use bcrypt or hash `Hash::make(request()->password)`

```
if(!Hash::check(request()->password,Auth::user()->password)):
    // false response
    else:
        // true response
endif;

```




## ================= date 23 Nov 2021 
> use axios,bulma,font-awesome(free version),jodit,moment,vue,vue-cookies,
vue-router,sanctum

> today I can do login,logout,get data from protected api route using 
vue-cookies to handle user token.
