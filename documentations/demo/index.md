# Quick start

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

---
## Installation

First of all, it is necessary to install prompt-flow. You can do it by running the following command:

```sh
composer require partitech/promp-flow
```

---
## Api key

For this example, we will use GPT-4, which requires an OpenAI API key. You can get one [here](https://openai.fr).

```php
$serperStep = new Serper(client: $this->serperClient, limit: $this->searchLimit);
$trafilaturaStep = new Trafilatura(
                    client: $this->trafilaturaClient,
                    minContentLength: 200,
                    maxContentLength: 4000
                );
$context = (new Context())->setQuestion($query);
$chat = new WebSearchChat($this->openAiClient, new ResultPrompt());
$chat->setStream(true);
$chat->setParameter(name: 'temperature', value: 0.1);
$chain = new Chain();
$chain  ->setContext($context)
        ->add($serperStep)
        ->add($trafilaturaStep)
        ->add($chat);
```

---
# GFM Admonitions (Notes) [doc](https://github.com/zenstruck/commonmark-extensions)
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



------
# Task list 
{.task-list}
- [x] #739
- [ ] https://github.com/octo-org/octo-repo/issues/740
- [ ] Add delight to the experience when all tasks are complete :tada:

------
# Lists
100. First list item
    - First nested list item
        - Second nested list item

1. James Madison
2. James Monroe
3. John Quincy Adams


- George Washington
* John Adams
+ Thomas Jefferson
------
# Quote
Text that is not a quote


> Text that is a quote


------
# Strikethrough Extension [doc](https://commonmark.thephpleague.com/2.6/extensions/strikethrough/) 
This extension is ~~really good~~ great!