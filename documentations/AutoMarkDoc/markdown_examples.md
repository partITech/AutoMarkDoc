## Titles and texts

# A first-level heading
## A second-level heading
### A third-level heading

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

```markdown
# A first-level heading
## A second-level heading
### A third-level heading

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
```

---
## Code

\```sh

this is a code zone

\```

```php

$serperStep = new Serper(client: $this->serperClient, limit: $this->searchLimit);
$trafilaturaStep = new Trafilatura(
                    client: $this->trafilaturaClient,
                    minContentLength: 200,
                    maxContentLength: 4000

```


```text
```php

$serperStep = new Serper(client: $this->serperClient, limit: $this->searchLimit);
$trafilaturaStep = new Trafilatura(
                    client: $this->trafilaturaClient,
                    minContentLength: 200,
                    maxContentLength: 4000

\```
```
> [!WARNING]
> Codeception is not allowed. So code tag inside code tag will bug.
> 
> Remove th backslash from the end of the code section :)

See [PrismJs documentation](https://prismjs.com/#supported-languages) for a complete list of supported languages.

---
# GFM Admonitions [doc](https://github.com/zenstruck/commonmark-extensions)
> [!NOTE]
> Useful information that users should know, even when skimming content.

> [!TIP]
> Helpful advice for doing things better or more easily.

> [!IMPORTANT]
> Key information users need to know to achieve their goal.

> [!WARNING]
> Urgent info that needs immediate user attention to avoid problems.

> [!CAUTION]
> Advises about risks or negative outcomes of certain actions.

```markdown
> [!NOTE]
> Useful information that users should know, even when skimming content.

> [!TIP]
> Helpful advice for doing things better or more easily.

> [!IMPORTANT]
> Key information users need to know to achieve their goal.

> [!WARNING]
> Urgent info that needs immediate user attention to avoid problems.

> [!CAUTION]
> Advises about risks or negative outcomes of certain actions.
```




------
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

------
# Task list
{.task-list}
- [x] #739
- [ ] https://github.com/octo-org/octo-repo/issues/740
- [ ] Add delight to the experience when all tasks are complete :tada:
> [!NOTE]
> There is no Js on this. You will have to implement it if you need it. **Send a PR ! :)**

------
# Lists
100. First list item
     - First nested list item
       - Second nested list item

101. James Madison
102. James Monroe
103. John Quincy Adams


- George Washington
* John Adams
+ Thomas Jefferson


```markdown
100. First list item
     - First nested list item
       - Second nested list item

101. James Madison
102. James Monroe
103. John Quincy Adams


- George Washington
* John Adams
+ Thomas Jefferson
```
------
# Quote
Text that is not a quote

> Text that is a quote

```markdown
> Text that is a quote
```
------
# Strikethrough Extension [doc](https://commonmark.thephpleague.com/2.6/extensions/strikethrough/)
This extension is ~~really good~~ great!
```markdown
This extension is ~~really good~~ great!
```