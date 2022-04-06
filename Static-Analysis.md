# Tool Used: PHPStan

- Free static analysis tool that checks php files for common errors.
- Checks For:
  - Existence of classes used in instanceof, catch, typehints and other language constructs. PHP does not check this and just stays instead, rendering the surrounded code unused.
  - Existence and accessibility of called methods and functions. It also checks the number of passed arguments.
  - Whether a method returns the same type it declares to return.
  - Existence and visibility of accessed properties. It will also point out if a different type from the declared one is assigned to the property.
  - Correct number of parameters passed to sprintf/printf calls based on format strings.
  - Existence of variables while respecting scopes of branches and loops.
  - Useless casting like (string) ‘foo’ and strict comparisons (=== and !==) with different types as operands which always result in false.
- Github link: https://github.com/phpstan/phpstan

# Static Analysis at Level 0 Testing (Lowest Level)

![image](https://user-images.githubusercontent.com/73197003/161871698-aba081f2-6af6-4a3c-8cc2-4607119067b5.png)


# Static Analysis at Level 9 Testing (Highest Level)

![image](https://user-images.githubusercontent.com/73197003/161871730-4fcbce70-b2fe-4829-a718-cc3a75ec572a.png)
