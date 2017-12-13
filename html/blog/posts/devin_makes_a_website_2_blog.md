<!-- #programming #webdev -->

# Devin Makes a Website: The Blog

Since my blog is becoming more and more like a sort of actual blog, I think I'll take a moment to talk about what's going on behind the scenes and how I built this thing. The blog is where most of my side development time has been going, so it only makes sense.

Bear in mind I am not what I'd consider an expert web developer, so I don't expect anyone reading this to take my approaches as a good example.

## Big Omissions

I had one thing in mind when I first started building the blog: simplicity.

I did not want to build my site atop a heavyweight framework, and I also chose to not use any SQL-powered database program on the backend to organize my posts.

My reasoning:

- PHP originated as a templating language - I have no pressing need for a more powerful templating setup.
- I don't need any sophisticated query capability or extensive metadata storage, so I don't feel the need to run MySQL.
- Also, [**insert meme here**](http://knowyourmeme.com/memes/roll-safe), not running either of those two mainstays of web dev means that I don't have to deal with most associated security vulnerabilities.

I don't claim these are necessarily good reasons at all. These technologies certainly would let me scale better if the blog became big, but for the time being I don't need them. I'm certainly not opposed to at least using SQL in the future, but I'm having plenty of fun with my lightweight setup at the moment. I also simply don't believe it's a great idea to [integrate potentially heavyweight technologies without a compelling reason to utilize them](http://www.phpthewrongway.com/#always-use-a-framework).

## How It Works

The blog's high-level design goal is that I can drop a Markdown file in a folder and then the server handles organizing it and presenting it to the user along with some light metadata.

We'll see what happens, from when I upload a post to when it reaches the reader.

### The Content

I drop my Markdown-formatted posts into [/blog/posts](devingunay.com/blog/posts). The only other formatting the blog relies on is a series of tags in a comment on the first line, and that the title of the post be the first header.

### The Metadata

In order to avoid having to generate metadata for every post on every single request, the server generates a text file archive with information about every post.

At some point, the archive generator I wrote runs through /blog/posts/*.md. For every post in the folder, it collects:

- The path to the file.
- Title, derived from the first header.
- Tags derived from a comment on the first line.
- The last modification time of the file, using [`filemtime()`](http://php.net/manual/en/function.filemtime.php).

It keys the data of each post by timestamp, and then sorts the archive most recent first. The data is output to a file as minified JSON.

### Presentation

When a user goes to my blog, the server uses the archive to fill post.php with the post content and the sidebar content.

The content is simply a call to [`file_get_contents()`](http://php.net/manual/en/function.file-get-contents.php) for that post. The content is parsed into HTML using [Parsedown](http://parsedown.org).

The sidebar uses the archive to grab the 5 most recent posts (since the archive is already sorted, this is just a simple [`array_slice($archive, 0, 5)`](http://php.net/manual/en/function.array-slice.php)).

The sidebar [archive](http://devingunay.com/blog/archive) structure (by year and month) is dynamically generated from the timestamps - it's super duper easy with the [`date()`](http://php.net/manual/en/function.date.php) function.

There you have it really. My blog essentially rests on the filesystem, the Parsedown library (28kb in a single file, ~1500 lines of code), and like 4 PHP core functions. I can get fancy with some [`array_filter()`](http://php.net/manual/en/function.array-filter.php) functional shenanigans and indeed do have some extra functions to get certain subsets of posts, but that's all the code that I deemed strictly necessary to accomplish the goal of setting up the blog.

## Possible Future Improvements

At the time of this writing, I planned to implement next/previous buttons below each post - and now I have them!

Another possible addition to the metadata of each post would be reading time, [calculated from a 275 WPM reading speed with adjustments for images](https://help.medium.com/hc/en-us/articles/214991667-Read-time).

Eventually, if processing all this stuff on every request becomes too burdensome, I could generate the blog as a cache of static HTML to serve, regenerating only when I add or modify a post.

I'm starting to understand one reason why JavaScript is so popular - instead of having to worry about doing all this as efficiently as possible on the server side, I could just make the user's machine do it every time they visit my blog.

While I have been looking for an excuse to write some JS, I'd rather it be a more tasteful one than that.