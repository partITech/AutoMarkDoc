# Tabbed Content [doc](https://github.com/zenstruck/commonmark-extensions)

- ===php 1

  ```php
  $chat->setStream(true);
  $chat->setParameter(name: 'temperature', value: 0.1);
  $chain = new Chain();
  $chain  ->setContext($context)
  ->add($serperStep)
  ->add($trafilaturaStep)
  ->add($chat);
  ```

- ===php 2

  Tab item 2 content

- ===Tab item 3

  > [!CAUTION]
  > Advises about risks or negative outcomes of certain actions.

```markdown
- ===php 1

  ```php
  $chat->setStream(true);
  $chat->setParameter(name: 'temperature', value: 0.1);
  $chain = new Chain();
  $chain  ->setContext($context)
  ->add($serperStep)
  ->add($trafilaturaStep)
  ->add($chat);
  ```

- ===php 2

  Tab item 2 content

- ===Tab item 3

  > [!CAUTION]
  > Advises about risks or negative outcomes of certain actions.
  ```
