# Work split among the teammembers:

1. Tommy
    - The header (header.php);
2. Ngaa
    - The footer (footer.php);
        - Including the newsletter (can be done using a pre-made script for mailing).
3. Rick
    - The main page (index.php)
4. Alvin
    - Creating the database
        - creating the tables;
        - making the connection between the tables;
    - The actual event page (from where a user can select a seat)
5. Nathan
    - The sport.php page (from where the user selects the sport he/she wants)
6. Alex
    - Login page (login.php)

## !! This are my thoughts on how we could begin only. If you have suggestions i would really appreciate if you would help!

# This are the rules to be followed while coding

- **Comment all your code**, be as specific as possible, especially on **non obvious** code!;
- I suggest we use double quotation (") in our code, just to be consistent...

- If the code **does not** have any PHP code, save it as an **HTML file**!
- For **HTML/CSS** _flexboxes_ and _grids_ must be used for aligning elements (preferably **flexbox**)!
- Addition to HTML: it would pe a best practice if you use HTML5 specific tags (such as: &lt;header&gt;, &lt;main&gt;,
  &lt;footer&gt;).
- Only **one** CSS file must be created!!
- HTML or PHP files which are required in _multiple_ files or are _repetitive_ must be created as a **separate
  document**!
  They will be accessed using php functions like: **include**, **include_once**, **require**, **require_once**.

    - <https://www.php.net/manual/en/function.require-once.php>;
    - <https://www.w3schools.com/php/php_includes.asp>

- Every communication with the database has to be done **secure**! This means that the **methods taught during the
  workshops** must be used (prepare, bind, store...)!
- Regarding sharing the database and its contents. I am not sure which is the best way of doing so yet, but for the
  begining i say after we alter the database on our local machine, we export the sql file and share it on GitHub (
  honesly, i have no clue of how to do this in a better way...).

## !!! You can always ask for help to your teammates or teachers in case you have trouble undersanding or meeting this set of rules.

# ========================================================================

# Rules for using Git, gid gud at git

1. **EVERY TIME BEFORE ADDING CHANGES TO GIT, PULL THE LATEST COMMITS (GIT PULL)**
2. **IF A WARNING MESSAGE APPEARERS WHEN YOU TRY TO PUSH SOMETHING, THEN TRY TO RUN "GIT PULL" AGAIN AND THEN TRY TO
   PUSH YOUR CHANGES**
3. **Don't use the browser for editing code inside github!!!**
    - But if you still have issues and you are not sure how to solve it, better contact somebody who knows how to work
      with git, as you might break the code
4. **GET COZY WITH THE TERMINAL, DON CRUTCH ON VSCODE MANAGING GIT FOR YOU OR GITHUB DESKTOP, THE TERMINAL IS BASICALLY
   A FILE EXPLORER THAT ACCEPTS COMMANDS**
5. **MOST IMPORTANT!!! If by any reason you did push a wrong commit, revert it immediately!**
    - Alex and I cant be arsed to create a new branch to fix all the shit that broke
6. **ASK FOR HELP, ALEX AND I AREN'T GIT CHADS YET BUT WE KNOW HOW TO GOOGLE :)**
7. **READ THE DOCS; NOPE READING THEM DOESN'T GET ANY EASIER**
   ![docs](docs/assets/docs.png)

## Current working directory

to see current changes in the use the `git status`
<br>
this will show you all the changes you have made from your previous commit.

```bash
# shows us the current branch that were working on, different branches are different versions of the same software
On branch main
# shows us if our local repo is up to date with the server repo
Your branch is up to date with 'origin/main'.

Changes not staged for commit:
# self explanatory
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
        modified:   README.md

no changes added to commit (use "git add" and/or "git commit -a")
```

when you add changes with git add, you stage them, this basically a snapshot of the current file at that time. changes
aren't permanent, but are prepared for the commit.

# Commits

## Creating commits

`git commit`. Commits are basically check points. you can add code and if you don't like it you can revert to a previous
commit removing all the changes you made.
<br>
`git commit -m "comment here"` commits with a short message
`git commit` opens up a vim editor for you to write commit messages, not worth unless you're a giga nerd

- ITS BEST PRACTICE TO STAGE MULTIPLE CHANGES AND THEN COMMIT ONCE, ITS FUN TO MEME AROUND BUT MAKE THE COMMIT MESSAGES
  USEFUL.

## Undoing commits

```
git reset HEAD~N
```

this undos your current commit to the previous commit by `N`

## getting older versions of files

```
git checkout <oldCommitHash> <path/to/file/from/project/root>
```

this gets a file/directory from a specific commit, useful for when you did something stupid and want to reset. WARNING,
it literally overwrites the local file, make sure you saved changes with `git stash` if you want to

### merging with other file

```
git checkout --patch <oldCommitHash> <path/to/file/from/project/root>
```

a more advanced feature(not really just read instructions) allows you to merge current file changes with older version
of any file

## Temporary storing with git stash

## Resolving merge conflicts
