# Title: Dependency Injection Challenge

## Learning objectives
- Understand the value of a Dependency Injection Layer
- Use the DI container inside Symfony
- Knows how to configure services and dependencies

## The Mission
Today we are going to learn on of the biggest game changers how you will write code in the future. We are going to dive into one specific implementation of the "Dependency Injection" design pattern (often abbreviated DI) in Symfony, but the general concept will be used in any major language in any major OOP-oriented language. Therefore it is really important to understand this concept.

Source material:
- [short video about DI](https://www.youtube.com/watch?v=IKD2-MAkXyQ).
- [basic explanation](https://www.freecodecamp.org/news/a-quick-intro-to-dependency-injection-what-it-is-and-when-to-use-it-7578c84fa88f/) about DI.

**In summary, the advantages of dependency injections are:**

- Your code is clean and more readable.
- Classes are loosely coupled.
- More reusable so it can be used in a different context.

### Service Locator vs Dependency Injection 
When you google DI you will often find a couple terms related to it, like Service Container, Service Locator or Service Container.

The difference between a Service Locator and a Dependency Injection Container is how you consume them. The implementation of both can be identical, but with a Service Locator you inject the container and ask it for the object you want, whereas with a Dependency Injection Container you use it to construct objects, but a Dependency Injection Container should only ever call itself, and never be called by any other objects.

In other words, your application is aware it's using a Service Locator, but your application should be totally un-aware that it's using a Dependency Injection Container.

That might sound complicated, but let's look at a code example.

Using Dependency Injection:
````php
class userController {
    function addUserAction(Logger $logger){
        $logger->log('I added a user');
    }
}
````

Using a service locator:
````php
class userController implements ServiceSubscriberInterface
{
    private $locator;

    public function __construct(ContainerInterface $locator) {
        $this->locator = $locator;
    }

    function addUserAction(){
        $this->locator->get(Logger::class)->log('I added a user');
    }
}
````

Which version do you prefer?

## Must-have features
### Step 1
1. Create an [interface](https://www.php.net/manual/en/language.oop5.interfaces.php) called `transform`, that requires one public method called `transform`, this function accepts a string and returns a string.

1. Make a class that capitalizes every other letter in a string (eg: "hElLo WoRlD"). Implement the `transform` interface.

1. Make another class that changes all spaces to dashes "-" (eg: "hello-world-i-love-to-code"). Implement the `transform` interface.

1. Make a logger class that logs messages in a file called "log.info".

### Step 2
Now make a "master" class that accepts a user input (simple form with 1 field). It should do the following.
- You log the message
- You echo it to the screen using the weird capitalization 
 
 Reuse the classes you made inside the master class, but you should not use the keyword "new" inside the master class. Pass it to the constructor.
 
To type hint the string transformation class, use the name of the `transform` interface instead of the concrete class you are using: you will see in step 3 why.
 
You can execute this master class in a simple controller.
 
 ### Step 3: Polymorphism
 Add a dropdown with 2 options in your form (keep it simple, just an html dropdown will be enough for now). The 2 options are the names of the 2 classes you made that transform a string. Make it so that depending on the user input one transformation is applied.
 
 **Do not change anything in your master class file!**
 
 If you did the previous step correctly you should be able to change the behavior of the master class without having to change any code in the master class! 
 
 This is a really powerful concept called **polymorphism**. It is made possible because both classes use **the same interface**, so they have the same function names: the code that uses this class does not care about which one it gets, as long as it has a function called `transform`.
 
In short: When two objects have the same interface, they are functionally interchangeable = polymorphism.
 
 ## Nice to have features
- Change your Logger class for Monolog
