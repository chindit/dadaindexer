# Important notice:
Currently, new SF CLI App is in alpha.
If you want, use «indexer-cli.php» and «schema.sql» as it's the old versions, but keep
in mind these files are obsolete and will be removed soon from the repository.

# DadaIndexer

PHP Indexation script

# Symfony CLI Application

## How to use it ?
Just launch the `phar` archive like this: `php dadaindexer.phar`

### NOTE
PHP version must be 7.1 or higher.

## Available commands

Available commands are following:
* `index` Create/update an index
* `check-filetype` Check if file extension is correct regarding to MIME type
(works only for pictures for now)
* `full-index` Perform a full index with clean of current index and thumbnails,
re-indexation and generation of missing pictures
* `clean` Remove obsolete entries from current index
* `clean-thumbs` Delete obsolete thumbnails
* `mkthumbs` Generate missing thumbnails
* `destroy` Destroy current index (but not thumbnails)
* `checksum` Generate missing checksums

## Global arguments

For all these commands, following arguments can be used:
* `-c /path/to/my/config.ini` or `--config /path/to/my/config.ini`

Configuration *must* be a valid `INI` file.
Allowed fields and default values are these:

```ini
[directories]
thumbsPath=thumbs/
duplicatePath=duplicates/
ignoredPath[]=..
baseDir=.
[thumbnails]
width=85
height=85
keepRatio=true
[mime]
ignoredMime[]=text/plain
ignoredMime[]=text/html
ignoredMime[]=text/css
ignoredMime[]=text/x-php
ignoredMime[]=application/javascript
ignoredMime[]=application/json
ignoredMime[]=application/xml
[database]
server=localhost
base=symfony
user=root
pass=
[databaseOptions]
charset=utf8
emulate=false
driver=mysql
[Options]
checkDuplicates=false
simulate=false
```

Any of these values can be overwritten and your `INI` file does not have to contains every parametere.
Setting just the parameters you want to change is valid.

For example, this `INI` file is valid

```ini
[database]
base=my_index
pass=my_root_pass
```

This custom config file can be loaded by this command for example :

`php dadaindexer.php index -c /path/to/my/custom.ini`

* `-d /path/to/index` or `--directory /path/to/index`

By default, _dadaindexer_ will take it's base directory as the root for index directory.
You can easily change this behaviour by setting the `-d` option.

If an index is already set and no `-d` value is provided, base directory of existing index
will be taken as root for requested operation.

## Commands in details

### Index
Most common way to call this command is by running this:

`php dadaindexer.phar index -c myconf.ini -d /my/index`

This command also supports these two optionals arguments:
* `--simulate` : simulate indexation and do not save anything in database
* `--keep-duplicates` : detect duplicate files but do *not* move them in `duplicates`directory
* `--check-duplicates` : calculate checksum of indexed files for fine detection of
possible duplicates.

***NOTE*** Argument `--keep-duplicates` will only be taken in consideration if
`--check-duplicates` parameter is given or activated in configuration.  Otherwise,
`--keep-duplicates` argument will simply be ignored.

### Check-filetype
This command just check if input file has the correct extension and require a `-f` argument pointing to a valid file.

Example:

`php dadaindexer.php check-filetype -f /path/to/my/file.png`

Please note that long version `--file` is also available.

### Full-index
This command takes no particular argument as it will only launch `clean-index`, `clean-thumbs`, `index` and `mkthumbs` commands
successively.  Optional arguments are those of these commands.

Example:
`php dadaindexer.phar full-index -c my/config.ini`

### Clean
This command takes no particular argument, except global `-c` and `-d`

Example:
`php dadaindexer.phar clean -d /my/index`

### Clean-thumbs
This command takes no particular argument, except global `-c` and `-d`

Example:
`php dadaindexer.phar clean-thumbs -d /my/index`

### Mkthumbs
A `--keep-aspect` argument can be sent to this command.
It will force thumbnail to respect source proportions, matching _width_ or _height_
limit as defined in config.
For example, with a thumbs size of 85x85 px, a vertical picture will have an height
of 85px and a lower width.

If this argument is omitted, all thumbnails will have the size defined in config file,
so, by default, 85x85px.

Example:
`php dadaindexer.php mkthumbs --keep-ratio -d /my/index -c my/config.ini`

### Destroy
Destroy current index.

Example:
`php dadaindexer.php destroy -d /my/index -c my/config`

### Checksum
Generate missing checksum for files.

*Warning* This operation can be time consuming.

A checksum is required for a fine detection of duplicates files, but it's
really time-consuming if you have big files, a lot of files and/or a weak machine.

By default, checksum is disabled and can be enabled in config or directly with the
`--check-duplicates` parameter when indexing.


# Legacy version

This version is available in the _indexer-cli.php_ file and should not be used.

## How to use it?

1)Create a new database and apply «schema.sql»

2)Open «indexer-cli.php» and adapte the «$infos» variable to your configuration.

3)Run «php indexer-cli.php help» to see a full list of available commands.

Main commands are these:

`php indexer-cli.php index/clean-index/mkthumbs/clean-thumbs`
