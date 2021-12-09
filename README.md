# lav8.bulma

## start on date 22 Nov 2021
> I know a little bit of laravel and I use laravel8 for my web app project but this project will be my first time that I will focus on a single page app
> this is the project laravel8 use bulma vue vue-router jodit-vue moment vue-cookies  






## ================= how to setup 

> this code will not work on your project as you're expected unless you're know 
> what you're doing

> so please watch this video 

[![watch how to setup ](http://img.youtube.com/vi/kzNHfPahoo8/0.jpg)](http://www.youtube.com/watch?v=kzNHfPahoo8 "")



## ================ Admin view user

> this is the admin preview user section I will make more video about this 
> for later

[![watch admin view user section ](http://img.youtube.com/vi/WPWzR5RrlPY/0.jpg)](http://www.youtube.com/watch?v=WPWzR5RrlPY "")




[lav8-bulma-1]:https://i.ibb.co/znGF6Sb/lav8-bulma-1.png
!["the first image from new project"][lav8-bulma-1]



## =============== Post page

> post page last update `8 Dec 2021`

[post_list_page]:https://i.ibb.co/hCNR0kG/post-list-8-dec-2021.png
[post_view_page]:https://i.ibb.co/rQNKYGv/read-post-8-dec-2021.png


> post list page 

![post list][post_list_page]



> post read page 

![post view page][post_view_page]




## ================= date 7 Dec 2021 
> make a read count ,category,tag system for post using `many to many` 
> (`return $this->belongsToMany()`) relationship.



> An Error on page `PostView.vue`

[![ Error on page PostView.vue ](http://img.youtube.com/vi/3DEK17rwfuU/0.jpg)](http://www.youtube.com/watch?v=3DEK17rwfuU "")





## ================= date 6 Dec 2021 

> added admin manage user section 



## ================= date 30 Nov 2021 

> the checkbox input is very small so I copy the style from `https://codepen.io/LucaCorigliano/pen/xjbOqB`

> then I put the code into the file `/sass/app.scss`

> in the file `app.scss` now I have code.


```

// Fonts
@import url('https://fonts.googleapis.com/css?family=Nunito');


//Bulma
@import '~bulma/bulma';

@import "node_modules/font-awesome/scss/font-awesome.scss";



// copy this code from `https://codepen.io/LucaCorigliano/pen/xjbOqB` on 30 Nov 2021
$primary: hsl(171, 100%, 41%);
$link:  hsl(217, 71%, 53%);
$info: hsl(204, 86%, 53%);


$success: hsl(141, 71%, 48%);
$warning: hsl(48, 100%, 67%);
$danger:  hsl(348, 100%, 61%);
$white:  hsl(0, 0%, 100%) ;
$black:  hsl(0, 0%, 4%) ;
$dark: hsl(0, 0%, 21%);
$light:  hsl(0, 0%, 96%) ;
$text: $dark;
$button-static-color: #7a7a7a !default;
$button-static-background-color: #f5f5f5 !default;
$button-static-border-color: #dbdbdb !default;
$button-border-width: 1px !default;
$button-padding-vertical: calc(0.375em - #{$button-border-width}) !default;
$button-padding-horizontal: 0.75em !default;
$radius-small: 3px;

$size-small: .75rem;
  $radius-small: 2px;
  $size-medium: 1.25rem;
  $size-large: 1.5rem;
  

@mixin button-small {
  font-size: $size-small;
}
@mixin  button-medium {
  font-size: $size-medium;
}
@mixin button-large {
font-size: $size-large
}

// Here starts the real code
label.is-checkbox {
  background: $link;
  &.is-primary {
    background: $primary;
 }
  &.is-info {
    background: $info;
    
  }
  &.is-danger {
    background: $danger;
  }
   &.is-warning {
    background: $warning;
     color: $text;
     .checkmark:before {
       background: rgba($light, 0.8);
     }
  } 
  &.is-success {
    background: $success;
  }
  &.is-static {
    background-color: $button-static-background-color;
    border-color: $button-static-border-color;
    color: $button-static-color;
    box-shadow: none;
    pointer-events: none;
         .checkmark:before {
       background: rgba($button-static-color,0.3);
     }
  }
  border: $button-border-width solid transparent;
  color: $white;
  text-align: center;
  white-space: nowrap;
  display: inline-flex;
  justify-content:center;
  &.is-primary {
    background: $primary;
  }
  padding: $button-padding-vertical $button-padding-horizontal;
  border-radius: $radius-small;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

  .checkmark {
    color: transparent;
    position: relative;
    i {
      z-index: 1;
      
    }
    &:before {
      content: '';
      position: absolute;
      right: 0;
      left: 0;
      top: 0;
      bottom: 0;
      z-index: 0;
      border-radius: $radius-small;
      background: rgba($dark, 0.3);
      border: 1px solid rgba($dark, 0.2);
    }
  }
  input[type="checkbox"] {
    position: absolute;
    visibility: hidden;
    cursor: pointer;    
    &:checked ~ .checkmark {
      color: inherit;
      
    }
  }
  
  &.is-rounded {
     border-radius: 9999px;
    .checkmark:before {
      border-radius: 9999px;
    }
  }
  
  &:hover {
    box-shadow: inset 0px 0px 9999px rgba(black, 0.05);
  }
  &:active {
    box-shadow: inset 0px 0px 9999px rgba(black, 0.1);
  }
  &.is-small {
    @include button-small;
  }
    &.is-medium {
    @include button-medium;
  }
    &.is-large {
    @include button-large;
  }
 .icon {
    &, &.is-small, &.is-medium, &.is-large {
        height: 1.5em;
        width: 1.5em;
        margin-left: -0.35em;
        margin-right: 0.35em;
    }

    
    &:first-child:not(:last-child) {
        margin-right: 0.1875em;
        margin-left:calc(-01.375em - #{$button-border-width});
    }
    &:last-child:not(:first-child) {
        margin-left: 0.1875em;
        
        margin-right:calc(-0.375em - #{$button-border-width});
    }
    &:first-child:last-child {
        margin-left:calc(-0.575em - #{$button-border-width});
    }
}
}

```


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
