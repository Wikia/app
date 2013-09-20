<?php
// example of how to use advanced selector features
include( dirname( __FILE__ ) . '/../simple_html_dom.php');

// -----------------------------------------------------------------------------
// descendant selector
$text = "
{{Companions sub (Awakening)}}
{{Companions sub (Dragon Age II)}}

[[Anders]]' dialogue contains a list of the conversations that Anders shares with the other companions, in which they discuss each other's backgrounds, and their reactions to the game's events.

==Awakening==
===Anders' Remarks===
*''(When deselecting him from party lineup)'' \"Andraste's Knickerweasels!\"
*''(When entering the City of Amaranthine)'' \"Ah, Amaranthine, the jewel of the north!\"
*''(When entering the Amaranthine market)'' \"I once knew someone who bought a piece of Andraste's shin-bone in the Amaranthine market.\"
*''(When passing by the pitchfork in the tree in the Amaranthine market)'' \"That's a strange place to store a pitchfork...\"
*''(On the bridge in Knotwood Hills)'' \"We're going down into that? Figures. Ooh it's an unstable crumbling chasm! Let's go and play in it!\"
*''(Upon seeing [[the Children]] for the first time)'' \"Why would we suddenly be seeing new forms of darkspawn? This isn’t even a Blight.\"
*''(Upon finding the secret passage in Kal'Hirol)'' \"I once started a rumor about secret passages in the tower. Had the templars pressing their noses to the walls for months. Hilarious!\"
*''(When walking inside Kal'Hirol Main Hall)'' \"Note to self: meat does not function well as an ornament.\"
*''(When nearing large lyrium container in Kal’Hirol Trade Quarter)'' \"This contraption is filled with pure lyrium. That much could kill an army.\"
*''(Kal’Hirol Lower Reaches, in the long hallway)'' \"Oh, the suspense is killing me.\"
*''(Kal'Hirol's Lower Reaches, near the broodmother pit)'' \"People have described broodmothers to me, but words don’t do them justice.\"
*''(When entering the Wending Wood upon seeing the wreaked caravan)'' \"Not to belabor the point or anything, but I think this caravan was attacked.\"
*''(At an overlook in the Wending Wood, near the suspicious camp.)'' \"Nice view. Do you see any large walking trees coming towards us?\"
*''(At burial pit in the Wending Wood)'' \"This place is a death trap! If I have to go into the bushes to answer nature's call, you're coming with me!\"
*''(At the Silverite Mine, upon seeing the ballista)'' \"That ballista is conveniently placed, isn’t it? Well, I’m always up for a spot of iconoclasm!\"
*''(Initial remark when entering the Blackmarsh)'' \"I’ve heard about this place. Didn’t an entire village up and vanished, or something?\"
*''(Past the old sign upon entering the Blackmarsh)'' \"I'm scared. Hold me?\"
*''(When nearing the dragon bone head in the Blackmarsh)'' \"Looks like the bones of this dragon were scattered by some animal. Or...something worse.\"
*''(Near a Veil Tear in the Blackmarsh)'' \"Will you look at that. A tear in the Veil. It must be even weaker in this marsh than I’d thought.\"
*''(Near ruined house in the Blackmarsh)'' \"It’s a picturesque little place, isn’t it? Aside from being ruined and haunted.\"
*''(First entering The Blackmarsh Undying)'' \"What was that thing? Who is “the Mother?” Another darkspawn?\"
*''(On the path toward the village in The Blackmarsh Undying)'' \"I see that the village in the Blackmarsh is not entirely forgotten, then.\"
*''(Approaching the coffins in the first room of the Shadowy Crypt)'' \"(Groans) I hate the Fade.\"
*''(Drake’s fall, on the first bridge)'' \"I’m betting the Tevinters built this. My question is why.\"

===Anders and [[Oghren]]===

*'''Anders''': You're quite the dirty little dwarf, aren't you?
*'''Oghren''': And you're quite the dirty little mage.
*'''Anders''': I do my best. Still, I'm no ale-swilling mountain of belches like you!
*'''Oghren''': And I'm no winking, slack-jawed coward like you.
*'''Anders''': True! We should form a club!
{{-}}
*'''Anders''': You don't actually think your jokes are funny, do you?
*'''Oghren''': Could have sworn that fly was buzzing again.
*'''Anders''': \"HAR! Let me tell you about my life in one word!\" (Belches)
*'''Oghren''': \"Oh no! Don't take me back to the tower! I'm far, far too delicate!\"
*'''Anders''': \"I'm not only a dwarf, I'm a moron! Listen to me fart!\"
*'''Oghren''': \"Oh no, big templar man! What are you going to do with that sword?\"
*'''Anders''': Eww.
*'''Oghren''': Don't play with fire unless you want to get burned, son.
{{-}}
*'''Anders''': I'm just going to assume that something died in your mouth.
*'''Oghren''': Funny story: dwarf attacks mage. Dwarf wins.
*'''Anders''': Yeah, I noticed how you pissed in your armor in that last fight. Well done.
*'''Oghren''': Thank you! I'll be here all week.
{{-}}
*'''Oghren''': (Grumbles) Women are drawn to you when you play with that cat.
*'''Anders''': Like moths to a flame. Women like it when men show affection for small, fuzzy, defenseless beings. Like you.
*'''Oghren''': Stupid... mage. Every time I pull something out of my robes, the women just flee.
{{-}}
*'''Oghren''': So... mage, huh? What's it like?
*'''Anders''': To have all this power at my fingertips?
*'''Oghren''': No. To always have to wear a skirt? (Laughs)
*'''Anders''': Oh, you don't know the story behind the robes? You know how strict things are in the Circle, right? Of course you do. Well, the robes make quick trysts in the corner easy. No laces or buttons. You're done before the templars catch on.
*'''Oghren''': Really?
*'''Anders''': Just ask anyone.
{{-}}
*'''Oghren''': And people talk about me stinking up the joint!
*'''Anders''': What are you on about, now?
*'''Oghren''': Cat piss! Little kitty there makes me want to vomit!
*'''Anders''': Don't listen to him, Ser Pounce-a-lot! You smell just fine.
*'''Ser Pounce-a-lot''': (Meow!)
{{-}}
*'''Anders''': Why did you even want to be a Grey Warden? You thought it would make for great drinking stories?
*'''Oghren''': I can't believe you survived the Joining.
*'''Anders''': You got drunk and made a bet, didn't you?
*'''Oghren''': I bet you I could crush your tiny human skull.
*'''Anders''': I bet I could drink you under the table.
*'''Oghren''': You're on!
{{-}}
*'''Oghren''': What?
*'''Anders''': What, what?
*'''Oghren''': You were staring at me, you manskirt-wearing freak.
*'''Anders''': Oh, I thought you were being attacked by a wild animal. But it was only your beard.
*'''Oghren''': You think you're so clever, don't you? Sparkle-fingers!

===Anders and [[Nathaniel]]===
*'''Anders''': So you're a Howe?
*'''Nathaniel''': Do you have a point, Mage?
*'''Anders''': Hey, I'm fond of the Howes! I'm also fond of the Whys, the Whos and the Whats.
*'''Nathaniel''': How clever.
*'''Anders''': ''(laughs)'' It's shameful how long it took me to come up with that.
{{-}}
*'''Anders''': You know, Nathaniel, you're just like me.
*'''Nathaniel''': Am I, now?
*'''Anders''': Everyone hates your family for something terrible they did, even though you weren't involved!
*'''Nathaniel''': I hope you have a point, Anders.
*'''Anders''': It's like you're a mage! If there were more Howes, they'd lock all of you up in a tower to protect everyone else!
*'''Nathaniel''': A thrilling analogy.
{{-}}
*'''Nathaniel''': I've thought about what you said, Anders. The comparison between my family and mages. It's idiotic. I am not about to transform into an abomination simply for being a Howe.
*'''Anders''': I didn't say it was a perfect analogy...
*'''Nathaniel''': Being a Howe also does not allow me to control your mind.
*'''Anders''': Kind of missing my point, aren't you?
*'''Nathaniel''': I am not a fan of over-simplifications.
*'''Anders''': Fine, fine. Your loss.
{{-}}
*'''Nathaniel''': You don't always wear robes, do you?
*'''Anders''': Not when I'm naked I don't.
*'''Nathaniel''': I mean when you run from the Circle. Robes would make you easy to spot.
*'''Anders''': So does the \"I'm a mage!\" sign around my neck. I like to make it easy for the templars.
*'''Nathaniel''': Ah, so that's how it's going to be.
{{-}}
*'''Nathaniel''': You seem rather attached to that cat, Anders.
*'''Anders''': It's more that he is rather attached to me. Isn't that right, Ser Pounce-a-lot?
*'''Ser Pounce-a-lot''': ''(Meow!)''
*'''Nathaniel''': Isn't that name a little... ridiculous?
*'''Anders''': What do you think I should call him? Frederick?
*'''Nathaniel''': There are worse names, I suppose...
{{-}}
*'''Nathaniel''': How do the templars always find you, Anders?
*'''Anders''': Incredibly angry, that's how they find me.
*'''Nathaniel''': There must be some trick to it, surely.
*'''Anders''': They began recruiting women. The male templars never stopped to ask for directions.
*'''Nathaniel''': You're impossible to talk to.
*'''Anders''': I do my best!

===Anders and [[Sigrun]]===
*'''Sigrun''': You should let Ser Pounce-a-lot out more. Must be stuffy in that robe.
*'''Anders''': Out? You mean out to play with the darkspawn? Such a great idea!
*'''Sigrun''': All right. I see your point.
{{-}}
*'''Anders''': Is there some great ceremony when someone joins the Legion of the Dead?
*'''Sigrun''': It's called a funeral.
*'''Anders''': Right, but is it boring and somber like a regular funeral? I mean, you're not burying anyone...
*'''Sigrun''': This is true. Dwarven funerals involve a great deal of ale and singing. Then there is an orgy.
*'''Anders''': What? You're kidding!
*'''Sigrun''': Of course I'm kidding.
{{-}}
*'''Anders''': So you never told me what that ceremony was like.
*'''Sigrun''': (Sigh) It begins with chanting and toasts. Then we bid our families farewell. Then, wailing and tears.
*'''Anders''': That does sound like a funeral. How depressing.
*'''Sigrun''': We're not the Legion of Jaunty Pub Songs.
*'''Anders''': But think how much easier recruitment would be if you were!
{{-}}
*'''Anders''': So what does the Legion do when you're not, you know, dying?
*'''Sigrun''': I'm not sure. We do that a lot.
*'''Anders''': But you can't do it all hours of the day. There must be some times when you're not out getting killed.
*'''Sigrun''': In those hours we listen to smart-mouthed mages ask stupid questions.
*'''Anders''': I always thought dwarves would be nicer.
*'''Sigrun''': I always thought mages would be smarter.
{{-}}
*'''Anders''': You seem fascinated with Ser Pounce-a-lot.
*'''Ser Pounce-a-lot''': (Meow!)
*'''Sigrun''': We don't have cats in Orzammar. Well, maybe some nobles have them, if they buy them from a surface merchant.
*'''Anders''': Everyone needs a pet.
*'''Sigrun''': Well, I had a nug once. For about an hour. Before my uncle slaughtered him and ate him.
{{-}}
*'''Sigrun''': Can you set that bush on fire?
*'''Anders''': Probably, but why would I want to?
*'''Sigrun''': Could you freeze it?
*'''Anders''': Why do you want me to kill the bush?
*'''Sigrun''': Because it's there! It's an evil bush! Do it!
*'''Anders''': Magic isn't for your amusement! Why don't I just do a little dance? Anders' Spicy Shimmy?
*'''Sigrun''': Oh, eww. I'll pass.

===Anders and [[Velanna]]===
*'''Anders''': Have I ever told you that I find tattoos on women incredibly attractive?
*'''Velanna''': Have I ever told you that I find most humans physically and morally repulsive?
*'''Anders''': Good to know!
{{-}}
*'''Anders''': Perhaps one day we could sit down to discuss magic?
*'''Velanna''': What would that accomplish?
*'''Anders''': Lots? Great civilizations are built on the sharing of ideas.
*'''Velanna''': Sharing? You mean stealing, of course. Followed by crushing those you stole from.
*'''Anders''': You know that chip on your shoulder? I think it has replaced your head.
{{-}}
*'''Velanna''': The chip on my shoulder hasn't replaced my head.
*'''Anders''': Whoa. She's talking to me. Voluntarily. Check the sky for flying pigs!
*'''Velanna''': Ugh. Forget it.
*'''Anders''': (Chuckles) I'm sorry. I couldn't help myself.
*'''Velanna''': (Sigh) Humans and their irrepressible urges.
{{-}}
*'''Velanna''': You escaped your Circle, didn't you?
*'''Anders''': Several times. But they always found me using my phylactery. Not that I minded being caught much. They always assigned the same templar to track me down. Or perhaps she asked. I hope it's the latter. On those long trips back to the tower -- I in manacles, she glaring silently -- the air practically sizzled.
*'''Velanna''': You escaped your Circle, repeatedly, for a woman?
*'''Anders''': Well, not ''for'' her. But she made being caught more fun. That's me, always looking on the bright side.
{{-}}
*'''Velanna''': My fireballs are bigger than yours.
*'''Anders''': It's not the size that counts, Velanna.
*'''Velanna''': Did they tell you that in your Circle? They were trying not to hurt your feelings.
*'''Anders''': The Circle lied to me? Andraste's sword, my world is falling apart! I have been unmanned!

===Anders and [[Justice]]===
*'''Anders''': Why do spirits seek out mages? I've always wondered.
*'''Justice''': You speak of demons. I am not a demon.
*'''Anders''': Aren't demons simply spirits with unique and sparkling personalities?
*'''Justice''': They have been perverted by their desires.
*'''Anders''': But what do they want from mages?
*'''Justice''': Perhaps they wish the same as I: silence.
{{-}}
*'''Justice''': I see that your feline companion remains with you.
*'''Anders''': He seems happy enough. Isn't that right, Ser Pounce-a-lot?
*'''Ser Pounce-a-lot''': (Meow!)
*'''Justice''': To enslave another creature does not seem just.
*'''Anders''': He's not a slave! He's a friend. And he's also a cat.
*'''Justice''': A cat that lacks freedom.
*'''Anders''': Just ignore him, Ser Pouce-a-lot. They don't have pets in the Fade, apparently.
*'''Ser Pounce-a-lot''': (Meow!)
{{-}}
*'''Justice''': I understand that you struggle against your oppression, mage.
*'''Anders''': I avoid my oppression. That's not quite the same thing, is it?
*'''Justice''': Why do you not strike a blow against your oppressors? Ensure they can do this to no one else?
*'''Anders''': Because it sounds difficult?
*'''Justice''': Apathy is a weakness.
*'''Anders''': So is death. I'm just saying.
{{-}}
*'''Justice''': I believe you have a responsibility to your fellow mages.
*'''Anders''': That bit of self-righteousness is directed at me?
*'''Justice''': You have seen oppression and are now free. You must act to free those who remain oppressed.
*'''Anders''': Or I could mind my business, in case the Chantry comes knocking.
*'''Justice''': But this is not right. You have an obligation.
*'''Anders''': Yes, well... welcome to the world, spirit.
{{-}}
*'''Anders''': Are you saying that you could become a demon, Justice?
*'''Justice''': I said no such thing.
*'''Anders''': You said that demons were spirits perverted by their desires.
*'''Justice''': I have no such desires.
*'''Anders''': You must have some desires...
*'''Justice''': I have none! Desist your questions!
{{-}}
*'''Anders''': I apologize, Justice. I didn't mean to suggest you would become a demon.
*'''Justice''': I should certainly hope not.
*'''Anders''': I just wondered what relation there is between spirits and demons. Demons are a worry to any mage.
*'''Justice''': I do not know what makes demons as they are. Such evil angers me, but I do not understand it.
*'''Anders''': Well, I hope you never come to understand.
*'''Justice''': I as well, mage. More than you could possibly know.

==Dragon Age II==
===Anders and [[Aveline]]===
ACT I
*'''Aveline''': I hear good things about you, Anders.  Not what I expected.
*'''Anders''': From a mage, you mean.
*'''Aveline''': I didn't say that.
*'''Anders''': How else would you judge me?  What else am I a shining example of?
*'''Aveline''': I don't know... other Fereldans lurking in Darktown?  Mage or not.
*'''Anders''': You... have a fair point.
{{-}}
*'''Anders''': So you married a templar, huh?
*'''Aveline''': What of it?
*'''Anders''': Are they all as dirty as they seem?
*'''Aveline''': What?
*'''Anders''': Did he ever ask you to play “the naughty mage and the helpless recruit?”  Maybe the “secret desire demon and the upstanding knight?”
*'''Aveline''': That's disgusting!
*'''Anders''': I hear it's quite popular.
{{-}}
*'''Aveline''': I could use your consult Anders.
*'''Anders''': Bring it to Darktown, and I'll get you a salve or something.
*'''Aveline''': What?  No!  I need to know some things about mages.
*'''Anders''': Why?
*'''Aveline''': I'm a guard.  I'm the first person who has to deal with... trouble.
*'''Anders''': You want help killing people like me.
*'''Aveline''': Not every mage can be trusted.
*'''Anders''': Nor every guard.
{{-}}
*'''Anders''': Do you ever miss Ferelden?
*'''Aveline''': Of course! It was home. I would never have left willingly.
*'''Aveline''': But I'm not going to be my father and spend my life trying to live a memory.
*'''Anders''': I didn't think I'd give it a second thought once I was gone. I mean, what did Ferelden ever do for me?
*'''Anders''': But I do. I think about it. There's something here that just doesn't feel right.
*'''Aveline''': You mean how mages are treated?
*'''Anders''': No... I think there's not enough dog shit.
{{-}}
ACT II
*'''Aveline''': You're glaring, Anders.  Is there a reason, or is it one of your moods?
*'''Anders''': Your term as captain hasn't been particularly \"mage friendly.\"
*'''Aveline''': I've only turned a handful over to the templars.
*'''Anders''': Every despot starts somewhere.
*'''Aveline''': And yet I allow an abomination to whine at me!  Credit where it's due.
{{-}}
*'''Aveline''': So you're two people, Anders and... Justice?
*'''Anders''': That's not strictly accurate.
*'''Aveline''': But you are of two minds.
*'''Anders''': Many people are.
*'''Aveline''': Now you're the one not being accurate.
*'''Anders''': I thought those were the rules of this game.
*'''Aveline''': I never know who I'm talking to with you.
*'''Anders''': Then it's fortunate it doesn't occur often.
{{-}}
*'''Anders''': So, I never expected to be palling around with the captain of the guard.
*'''Aveline''': We're not \"pals.\"
*'''Anders''': We're not? What about that time we painted each other's toenails?
*'''Aveline''': Do you want something?
*'''Anders''': Love, life, and liberty. What more does a man need?
*'''Aveline''': You're in a jolly mood.
*'''Anders''': Well, when you're here, I know you're not leading men into Darktown to arrest me.
{{-}}
<small>(If Ella was killed during [[Dissent]])</small>
*'''Anders''': Can I ask you something, Aveline?
*'''Aveline''': I cannot look the other way when mages break the law--
*'''Anders''': That's not what I was going to ask.
*'''Anders''': There's a girl. A mage apprentice. She...was murdered in the Gallows recently. Have you heard anything of it?
*'''Aveline''': You mean the girl you killed.
*'''Anders''': Yes. I'd like to... attend the funeral. Do something.
*'''Aveline''': The official templar report says she was killed by a demon of unknown origin.
*'''Aveline''': Let her family mourn in peace.
{{-}}
ACT III
*'''Anders''': I suppose you're just thrilled how the knight-commander's basically stepped into the viscount's seat?
*'''Aveline''': She can't stall the process forever. It's not her place.
*'''Aveline''': Leaving the viscount's seat empty will just tempt people to fight for it. It will cause more trouble than it prevents.
*'''Anders''': Well. You've got a brain in there after all.
*'''Anders''': I was convinced that headband was to keep it from falling out.
{{-}}
*'''Aveline''': I have to admit, Anders. Of the mages I know, you're the one I expected to go out in a blaze.
*'''Anders''': The day is young.
*'''Aveline''': It was a compliment, you ass.
*'''Anders''': No, it wasn't.
{{-}}
*'''Anders''': Your husband agrees with me.
*'''Aveline''': About what?
*'''Anders''': He thinks the knight-commander's mad. He told me she's gone behind your back to investigate guardsmen she suspects as secret mages.
*'''Aveline''': Even if that were true, he wouldn't tell you.
*'''Anders''': He won't fight for her when the time comes. Would you turn against your own husband?
*'''Aveline''': I don't know if you're lying or crazy.
{{-}}
<small> (During [[The Last Straw]]) </small>
*'''Aveline''': Just to be clear Anders: when this is over, you <b>will</b> turn yourself in for your crime.
*'''Anders''': I'm well aware of your commitment to oppression. 
*'''Aveline''': The laws of the land. Fairly applied to everyone. 
*'''Anders''': That...is actually something I'd very much like to see.

===Anders and [[Bethany]]===
*'''Bethany''': So, you were in the Circle and ran away. I don't know if I'd be brave enough to do that.
*'''Anders''': You've been an apostate your whole life.
*'''Bethany''': Exactly. It was never anything I had to work for.
*'''Bethany''': Other people always took the risks, to keep me free.
{{-}}
*'''Anders''': Where did you learn your magic?  I mean, you know my feelings on the Circle, but usually it's the only decent training a mage can get.
*'''Bethany''': My father taught me.  He was in the Circle once, trained there.  But he got away.
*'''Anders''': You don't know how lucky you were, to have someone who loved you and could help you.  Most mages would kill for that.
*'''Bethany''': You remind me of him.
{{-}}
*'''Anders''': The Rite of Tranquility is the whole problem.  If they didn't have that to hold over us, we'd have so many more options.
*'''Bethany''': Right! If we want to fight back... or just engage in intelligent debate... they make sure we can't do it.
*'''Anders''': They're forcing our hands.  There's no way to change things peacefully.
*'''Bethany''': There must be something.
*'''Anders''': If it's Tranquility or death, we have no choice but to make every confrontation a life-or-death struggle.
*'''Bethany''': I know, but... there are good people in the Circle, the Chantry.  There has to be a way to reason with them.
*'''Anders''': Not if they take away your ability to reason.
{{-}}
*'''Bethany''': I know it didn't work the way you wanted, but... it was brave, what you did with Justice.
*'''Anders''': It was meant well.  I don't know if that's enough to forgive me.
*'''Bethany''': It must have been hard for him, being trapped outside the Fade.  In a place where no one's like him.
*'''Bethany''': I bet he appreciated having a friend.
*'''Anders''': He did.

===Anders and [[Carver]]===
*'''Anders''': You don't like me, Carver?
*'''Carver''': I don't like you.
*'''Anders''': That's unfortunate. Hating someone just because they're a mage is a shameful thing.
*'''Carver''': I don't hate you because you're a mage. I hate you because you won't shut up about it.
*'''Carver''': Oppression this, templars that. I'd heard enough long before you.
*'''Anders''': Maybe it's time you put some thought into it.
{{-}}
*'''Carver''': What are you looking at?
<small>If Hawke is male:</small>
*'''Anders''': Your brother is a mage. As was your sister and father?
<small>Otherwise:</small>
*'''Anders''': Your sisters are... were both mages, as was your father?
*'''Carver''': And I'm not. What of it?
*'''Anders''': Nothing, it's not always passed to all siblings. But it's good to know that you understand our plight.
*'''Carver''': Shove your plight.
{{-}}
*'''Anders''': I'm sorry about your sister. She sounds like a special girl.
*'''Carver''': Why? Because she was a mage?
<small>If Hawke is female:</small>
*'''Anders''': Your other sister says she was a good person. That she never turned down a chance to help people.
<small>Otherwise:</small>
*'''Anders''': Your brother says she had a good heart. Being on the run never made her bitter.
*'''Carver''': Yes, yes. I'm sure the Chantry's got a shrine with her portrait on it.
*'''Anders''': I was trying to be nice.
*'''Carver''': Stick to surly. It works for you.
{{-}}
*'''Anders''': Nice day to be planning a trip into the Deep Roads, don't you think?
*'''Anders''': The Blight, the dampness, the festering darkness filled with tainted rats...
*'''Carver''': Shut up.
*'''Anders''': You've got a real chip on your shoulder, you know?
*'''Carver''': I've got a big blade on my shoulder, magey.
*'''Anders''': Right. Wonder what you're compensating for.
{{-}}
LEGACY
<small>If Carver joined the Templars:</small>
*'''Anders''': So, templar. Is the order everything you wished for?
*'''Anders''': Pithed any good mages lately? That's what you do now, right?
*'''Anders''': It must wear on you, given your lineage. No wonder you're quiet.
*'''Carver''': Be grateful. You're free because you know my brother/sister. Don't push it.
*'''Anders''': Oh, ''yes'' ser, ''please'' ser.

===Anders and [[Fenris]]===
ACT I
*'''Anders''': You ever going to stop harping on the mages here?
*'''Fenris''': No.
*'''Anders''': They aren't what you saw in Tevinter.
*'''Fenris''': The moment they are free, mages will make themselves magisters.
*'''Anders''': They're slaves!  You should want to help them.
*'''Fenris''': I don't.
{{-}}
*'''Anders''': So, there must be mages in Tevinter that don't use blood magic.
*'''Fenris''': Of course.  There are slaves.  The magisters do not hesitate to collar their own kind.
*'''Anders''': But no magisters?
*'''Fenris''': Why must you go on about this?  No magister would turn down an advantage over his rivals.  If he did, he'd be dead.
*'''Anders''': You know, to use blood magic you must look a demon in the eye and accept his offer.
*'''Anders''': I just figured some of them would say no.  For aesthetic reasons, if nothing else.
{{-}}
*'''Fenris''': Did I hear correctly?  You are an... abomination?
*'''Anders''': Why don't you shout?  I don't think everyone heard you.
*'''Fenris''': Do you see yourself as harmless, then?  An abomination who would never harm someone?
*'''Anders''': Like ripping someone's heart out of his chest?
*'''Fenris''': I did that at the behest of no demon.
*'''Anders''': So we agree that it doesn't take a demon for someone to be a vicious killer?  Good.
{{-}}
*'''Fenris''': Why was your friend made Tranquil?  Do you know?
*'''Anders''': No, and it doesn't matter.  Nobody deserves that.
*'''Fenris''': I know some mages that deserve that.
*'''Anders''': Really? Perhaps they should start making slaves Tranquil—then they wouldn't dream of escaping!  Wouldn't that be wonderful?
*'''Fenris''': Slaves do not attract demons that try to possess them.
*'''Anders''': Which clearly justifies it?  What a perfect solution!
{{-}}
ACT II
*'''Fenris''': Is there something you want, Anders?
*'''Anders''': You really don't have the temperament for a slave.
*'''Fenris''': Is that a compliment or an insult?
*'''Anders''': I'm just wondering how your master didn't kill you.
*'''Fenris''': How have the templars not killed you?
*'''Anders''': I'm charming.
{{-}}
*'''Anders''': Did you ever think about killing yourself?
*'''Fenris''': I could ask you the same thing.
*'''Anders''': I'm serious. To get out of slavery, to escape Danarius... don't tell me you never thought about it.
*'''Fenris''': I did not. To kill oneself is a sin in the eyes of the Maker.
*'''Anders''': You... believe that?
*'''Fenris''': I try to. Some things must be worse than slavery.
*'''Anders''': Some things are worse than death.
{{-}}
*'''Fenris''': You should have lived in Tevinter. You'd be happier there.
*'''Anders''': You're probably right.
*'''Fenris''': There, your magic would be a mark of honor. Apprenticed to the right Magister, you would do well.
*'''Anders''': Is there a down side?
*'''Fenris''': Only if you're bothered by owning a few slaves and performing the occasional blood ritual.
*'''Anders''': So they all do those things?
*'''Fenris''': Just the ones who don't complain about how powerless and persecuted they are.
{{-}}
<small>If you complete [[Dissent]]</small>
*'''Fenris''': I seem to recall you saying something a while ago...
*'''Anders''': Shut up.
*'''Fenris''': \"I can control it.\" Wasn't that what you said?
*'''Anders''': So help me...
{{-}}
ACT III
*'''Anders''': Do you still support the Knight-Commander?
*'''Fenris''': I don't care a fig for her. But she's the only one holding back the madness in this city.
*'''Anders''': Holding back? She's howling at the bloody moon!
*'''Anders''': Even her own people think she's lost it.
*'''Anders''': What will it take for you to see that she's crazy?
*'''Fenris''': Mages in glass houses shouldn't throw fireballs.
{{-}}
*'''Anders''': By now, you must see what an injustice the templars are.
*'''Fenris''': Must I? I see templars trying to control what they have good reason to fear.
*'''Anders''': But they go too far.
*'''Fenris''': Talk to Hawke about his/her mother. Ask him/her who went \"too far.\"
*'''Anders''': You can't hold all mages responsible for that!
*'''Fenris''': It doesn't take all mages to cause this. Only the weak ones.
{{-}}
*'''Anders''': Not all mages are weak.
<small>If Hawke is a mage:</small>
*'''Fenris''': True. Hawke, for instance, is not weak.
<small>Otherwise:</small>
*'''Fenris''': Bethany, for instance, was not weak.
*'''Anders''': You specifically don't mention me.
*'''Fenris''': That's also true.
*'''Anders''': I'll prove to you that I'm not weak
*'''Fenris''': Prove it to yourself. You're convincing no one else.
{{-}}
<small>If Hawke spent the night with Fenris</small>
*'''Anders''': I can't imagine what Hawke sees in you.
*'''Fenris''': It is done. Leave it be.
*'''Anders''': Well, good. I always knew she/he had some sense.
*'''Fenris''': Do not make light of this. Leaving was the hardest thing I've ever done.
<small>If Isabela is in the party</small>
*'''Isabela''': Oh, will you two get over yourselves? You're like two dogs around a bitch in heat.
*'''Fenris''': We were talking about Hawke. Not you.
<small>If Isabela is in the party and you slept with her as well</small>
*'''Isabela''': Oh, will you two get over yourselves? I did her/him too.
{{-}}
<small>If Hawke spent the night with Fenris, but moved on to Anders</small>
*'''Anders''': You were an idiot to leave Hawke.
*'''Fenris''': And ''you'' were fast enough to replace me.
*'''Anders''': I love him/her. You can't even imagine what that is.
*'''Fenris''': Do not bare your heart to me, mage, unless you would have me rip it out.
{{-}}
<small>If Hawke spent the night with Fenris, but moved on to Anders</small>
*'''Fenris''': You... are living with Hawke now?
*'''Anders''': What's it to you?
*'''Fenris''': Be good to him/her. Break his/her heart, and I will kill you.
{{-}}
<small>If Hawke romanced Fenris and with Fenris in the party</small>
*'''Anders''': I know it isn't my place to criticize, but...
*'''Anders''': Are you sure about Fenris?
*'''Anders''': He seems less a man to me than a wild dog.
*'''Hawke''': You just don't know him.
*'''Anders''': I know as much as I'm ever likely to.
*'''Fenris''': That's right, mage.
*'''Anders''': He has let one bad experience color his whole world. Surely you want someone more openminded?
*'''Fenris''': A mage and a hypocrite. What company you keep.
{{-}}
LEGACY
*'''Fenris''': You speak of disliking the Deep Roads a great deal. Why?
*'''Anders''': Besides the obvious, you mean?
*'''Fenris''': It is a dangerous place, but less so for a Grey Warden.
*'''Anders''': Darkspawn this, darkspawn that. Taint taint taint taint taint.
*'''Anders''': After a while, you just get so tired of it, you know?
*'''Fenris''': I... do now.

===Anders and [[Isabela]]===
ACT I
*'''Isabela''': Hello?  Is Anders there?  Can I speak to Anders?
*'''Anders''': You can stop yelling.  It's always me.
*'''Isabela''': Oh, good.  I didn't want to talk to that other guy.  You know, the stick-in-the-mud.
*'''Anders''': He can still hear you.  Justice and I are one.
*'''Anders''': Anyway, you wanted to talk to me?
*'''Isabela''': Not really.  I just wanted to make sure it was you.
{{-}}
*'''Anders''': I keep thinking I know you from somewhere...
*'''Isabela''': You're Fereldan, right?  Ever spend time at the Pearl?
*'''Anders''': That's it!
*'''Anders''': You used to really like that girl with the griffon tattoos, right?  What was her name?
*'''Isabela''': The Lay Warden?
*'''Anders''': That's right!  I think you were there the night I—
*'''Isabela''': Oh!  Were you the runaway mage who could do that electricity thing?  That was nice...
*'''Hawke''': Please stop talking.  Now.
<small>Or if Varric is in the party</small>
*'''Varric''': I don't think I need to know this about either of you.
{{-}}
*'''Anders''': Isabela, you never talk about the mages' plight.
*'''Isabela''': What's there to say?
*'''Anders''': There's plenty to say.
*'''Isabela''': And you say enough for the lot of us, don't you think?
*'''Anders''': So you're telling me you have no opinion on the matter?
*'''Isabela''': None whatsoever!
*'''Anders''': That can't be true.
*'''Isabela''': No, I'm afraid I'm really this shallow.
{{-}}
*'''Anders''': Sometimes, I think you have the right idea.
*'''Isabela''': Handcuffs, whipped cream, always be on top?
*'''Anders''': I never used to give two bits what anyone thought of me.
*'''Anders''': Justice once asked me why I didn't do more for other mages.  I told him it was too much work.
*'''Anders''': But I couldn't go back after that.  Couldn't stop thinking about it.
*'''Anders''': Sometimes, I miss being that selfish.
*'''Isabela''': Huh?  Were you talking?  I was still at \"whipped cream.\"
{{-}}
ACT II
*'''Anders''': What makes this relic of yours so valuable?
*'''Isabela''': The same thing that makes anything valuable. Someone's willing to pay for it.
*'''Anders''': That's not evasive.
*'''Isabela''': Look, I didn't get where I am by showing my hand, you know?
*'''Anders''': No, you're hand isn't what I hear you've been showing.
{{-}}
*'''Anders''': Do you ever have any regrets?
*'''Isabela''': About what?
*'''Anders''': Anything? Everything? I can't figure you out.
*'''Isabela''': The past's past. I learned that young. If it can't bring you gold or giggles, what's the point in dwelling on it?
*'''Anders''': Maybe the chance to fix a mistake? Make things right again?
*'''Isabela''': Eh. Our mistakes make us who we are.
*'''Anders''': That was almost profound.
{{-}}
*'''Anders''': So, this relic you lost... how is it you don't know what it is?
*'''Isabela''': It was in a box.
*'''Anders''': And you didn't open it? You managed to resist the urge?
*'''Isabela''': It was locked. It was a locked box!
*'''Anders''': Hasn't stopped you before.
*'''Isabela''': What do you want me to say?
*'''Anders''': Nothing. I just found it curious, that's all.
{{-}}
*'''Anders''': You do have an opinion on mages, don’t you?
*'''Isabela''': Of course I do. I just don't feel a constant need to bring it up.
*'''Isabela''': (Sighs) Mages don’t worry me. And I don't believe the templars when they say I should be worried.
*'''Isabela''': I’m more likely to be shanked in a bar than eaten by an abomination. You can hear those coming a mile away.
*'''Isabela''': \"Grr. Argh!\" \"Oh, is that an abomination coming to eat us? We should get out of here!\"
*'''Anders''': Abominations don't go, \"Grr. Argh.\"
*'''Isabela''': They don't? I should rethink the whole thing, then.
{{-}}
ACT III
*'''Anders''': You're not nearly as selfish as you pretend.
*'''Isabela''': Hey!  You take that back!
*'''Anders''': You had your relic.  You were gone.  There was no reason for you to come back and face the Qunari.
*'''Isabela''': I still don't have a ship.  I thought I could get one.
*'''Anders''': From a bunch of shipwrecked Qunari?
*'''Isabela''': From the Viscount.  I just got here late.
*'''Anders''': I always knew you had a heart of gold.
*'''Isabela''': Shh!  Don't tell anyone.
{{-}}
*'''Anders''': I don't know how you live the way you do, blithely ignoring the consequences of your actions.
*'''Isabela''': This is about the Qunari thing, isn't it? I'm not ignoring it. I just recognize that it happened years ago.
*'''Isabela''': There's this fantastic thing called \"moving on.\" You should try it sometime.
*'''Anders''': Has it occurred to you that Kirkwall is only just recovering from the Qunari attack?
*'''Isabela''': And you want me to... what? Flog myself daily?
*'''Isabela''': Has it occurred to you that maybe there's no justice in the world? Other than that voice you keep in your head.
{{-}}
*'''Anders''': I can't believe you're still not taking sides.
*'''Isabela''': I told you, I only like to be on top.
*'''Anders''': I mean against the templars! You like freedom, right? You hate slavery.
*'''Anders''': Why wouldn't you side with the mages?
*'''Isabela''': Maybe I just don't like you.
{{-}}
*'''Anders''': There is justice in the world.
*'''Isabela''': Is there? You want to free the mages. Let's say you do, but to get there, you kill a bunch of innocent people.
*'''Isabela''': What about them? Don't they then deserve justice?
*'''Anders''': Yes.
*'''Isabela''': And then what? Where does it end?
*'''Isabela''': It's like a bar brawl. People are continuously pulled into the fray, and nobody remembers why it started.
*'''Isabela''': Justice is an idea. It makes sense in a world of ideas, but not in our world.

===Anders and [[Merrill]]===
ACT I
*'''Anders''': So, when you first did blood magic, it was... just an accident, right?
*'''Anders''': You cut yourself and realized the power?  You didn't actually deal with a demon?
*'''Merrill''': Oh, no.  I did.
*'''Anders''': Why would you do that?
*'''Merrill''': I needed his help.  He was really very nice about it.
*'''Anders''': Of course he was!  He's using you to get a foothold in a mortal brain!
*'''Merrill''': He's a spirit.  He offered me his aid.  I hardly think you're one to criticize.
{{-}}
*'''Merrill''': I heard Varric saying you were a Grey Warden.
*'''Anders''': I was.
*'''Merrill''': I met a warden once.  Back in Ferelden.  Duncan, I think his name was.  Very odd man.
*'''Merrill''': He had a marvelous beard, though.  I'd never seen one before.  I thought a squirrel had grabbed him by the chin.
{{-}}
<small>If the Hero of Ferelden was Dalish</small>
*'''Merrill''': I heard Varric saying you were a Grey Warden.
*'''Anders''': I was.
*'''Merrill''': Did you... did you ever meet a Dalish Warden?  Mahariel?
*'''Anders''': As a matter of fact, I did.
*'''Anders''': Do you know her/him?
*'''Merrill''': We grew up together.  She/He was one of my clan.
*'''Merrill''': I keep hoping to hear some news...
*'''Anders''': I wouldn't get your hopes up.  The Hero of Ferelden values privacy rather highly.
{{-}}
<small>If the Hero of Ferelden was Dalish, but died killing the Archdemon</small>
*'''Merrill''': I heard Varric saying you were a Grey Warden.
*'''Anders''': I was.
*'''Merrill''': Did you... did you ever meet a Dalish Warden?  Mahariel?
*'''Anders''': No.  I had a friend who did, though.  Told the most impossible stories.
*'''Merrill''': I'd like to hear them, sometime.  If you don't mind.
<small>In all likelihood, the friend Anders is referring to is [[Oghren]]</small>
{{-}}
*'''Merrill''': Ser Pounce-a-lot... who knighted him?
*'''Anders''': Is that a serious question?
*'''Merrill''': Did he have a little sword, or just his claws?  I bet he had a dashing cap with a feather in it!
*'''Anders''': Would you stop making fun of my cat?
*'''Merrill''': Oh... no hat, then?
{{-}}
*'''Anders''': Maybe you don't really understand the difference between spirits and demons.
*'''Merrill''': Did I ask you?
*'''Anders''': Spirits were the first children of the Maker, but He turned his back on them to dote on His mortal creations.
*'''Anders''': The ones who resented this became demons, driven to take everything mortals had and gain back the Maker's favor.
*'''Merrill''': Your \"Maker\" is a story you humans use to explain the world.
*'''Merrill''': We have our own stories.  I don't need to borrow yours.
{{-}}
ACT II
*'''Merrill''': You could get another cat, you know. There's one in the Lowtown market with a litter of kittens ready to wean.
*'''Anders''': You don't pay attention to templars, Qunari or politics, but you notice kittens?
*'''Merrill''': Templars, Qunari, and politics don't meow and attack your feet when you're buying food.
*'''Anders''': Are there any tabbies? I'd like a tabby.
{{-}}
*'''Anders''': Do Dalish honestly not recognize the difference between demons and beneficial spirits?
*'''Merrill''': We’ve never thought of the Fade as the home of our gods.
*'''Merrill''': It is another realm, another people's home. No different or more foreign than, say, Orzammar.

<small>If Varric is in the party:</small>
*'''Varric''': You can say that again.

*'''Anders''': But have you never studied the types of demons? They break down very clearly into different sins—
*'''Merrill''': Spirits differ from each other, just as you and Hawke and Isabela are all human.
*'''Merrill''': More or less...
{{-}}
<small>If you complete [[Dissent]]</small>
*'''Merrill''': Are you all right?
*'''Anders''': I nearly killed an innocent girl. How could I be all right?
*'''Merrill''': I'm sorry.
*'''Anders''': You're sorry? For me? This could be you! You could be the next monster threatening helpless girls!
*'''Merrill''': Anders... There's no such thing as a good spirit. There never was.
*'''Merrill''': All spirits are dangerous. I understood that. I'm sorry that you didn't.
{{-}}
<small>If you complete [[Dissent]]</small>
*'''Anders''': It's not a good feeling, you know.
*'''Merrill''': What?
*'''Anders''': Being an abomination. I just got a taste of your future.
*'''Merrill''': I'm not that foolish. Our relationship is, um, strictly platonic.
*'''Anders''': It's like you're trapped in your own body, seeing out your eyes, while someone else moves you like a puppet.
*'''Anders''': And you're trying to scream, to move a single muscle, but there's no escape. Until you look down at the blood on your hands...
*'''Merrill''': Stop it. You're scaring me.
*'''Anders''': That's the point.

** Note: Due to the glaring contrast in characterization between these two dialogs, it seems likely that Anders' banter dialog is bugged, and only one is meant to fire, depending on either Anders' or Merrill's Friendship/Rivalry status (see also his conversation with Isabela about her selfishness or lack thereof).

{{-}}
ACT III
*'''Anders''': You must join us. Do you see that now? You must stand with Kirkwall's mages.
*'''Merrill''': It's not my fight.
*'''Anders''': You can't hide in Sundermount.
*'''Anders''': There is no place for you among the Dalish.
*'''Merrill''': No! My clan is all I ever cared about! Everything I did, I did for them!
*'''Anders''': On second thought, maybe don't try to help us.
{{-}}
*'''Merrill''': Have I ever mentioned I like your coat?
*'''Anders''': You do?
*'''Merrill''': It's very lively! Like a crow in the middle of anting!
*'''Anders''': That's.... that's great. Thanks, Merrill.
<small>If Varric is in the party</small>
*'''Varric''': I tried to warn you, Blondie.
*'''Anders''': You're not helping.
<small>If Isabela is in the party</small>
*'''Isabela''': I wouldn't have called them \"lively.\" Bedraggled, maybe. Or just... fluffy.
*'''Anders''': You're not helping.

{{-}}
*'''Merrill''': You really believe don't you?
*'''Anders''': What are we talking about?
*'''Merrill''': Believing. You do I can tell, in freedom, in mages, in good spirits and bad templars. With more fire than the sun.
*'''Anders''': And your point is?
*'''Merrill''': I miss it sometimes, things being certain.
*'''Anders''': Some things are certain.
*'''Merrill''': Not anymore.
{{-}}
<small>During [[A New Path]]</small>
*'''Anders''': I don't know why I'm bothering with this, but you do realize it is crazy, right?
*'''Merrill''': Believe me I noticed, if I had any other choices, I'd take them.
*'''Anders''': You have choices! You always had choices! Stop using blood magic. Get rid of that damned mirror.
*'''Merrill''': Oh in that case, I will head back to Kirkwall and throw it away, right after you abandon the plight of the circle of mages.
{{-}}
<small>If you complete [[A New Path]]</small>
*'''Anders''': Your Keeper did not deserve that death.
*'''Merrill''': It was my risk to take! I never asked her to do this for me.
*'''Anders''': She knew you didn't have the strength to resist the demon. That's why it picked you.
*'''Merrill''': Why are you doing this? What can I do about it now?
*'''Anders''': Make up for your mistakes. Most blood mages never get a second chance.
{{-}}
<small>If Hawke romanced Merrill but also slept with Isabela</small>
*'''Anders''': Hawke was a fool to let you move in. You'll only betray him/her. That's all your kind can do.
*'''Merrill''': Why do you only do this to me? Are you jealous? You don't get upset about Hawke and Isabela.
*'''Anders''': You can't really get jealous of someone for sleeping with Isabela. It's just...understood.
*'''Anders''': She's like a side dish. She comes with the meal.
<small>If Isabela is in the party</small>
*'''Isabela''': Only if it's a good meal.
{{-}}
<small>If Hawke romanced Anders</small>
*'''Merrill''': Are you happy?
*'''Anders''': Beg your pardon?
*'''Merrill''': S/He seems happy. Hawke, I mean. Are you?
*'''Anders''': Yes, I suppose I am.
*'''Merrill''': Good! You've spent much too much time being grumpy. It's a nice change.
{{-}}
<small>During [[Justice (Quest)]] if Hawke has romanced Merrill</small>
*'''Anders''': I know it isn't my place to criticize, but... are you sure about Merrill?  She acts sweet, but she'll never choose you over her demon.
*'''Hawke''': Merrill loves me.
<small>If Merrill is in the party</small>
*'''Merrill''': What right to you have to question us?  Is your Justice any different?
*'''Anders''': Yes.  Keep your illusions then.  Maker knows I won't be the one to change them.
OR
*'''Hawke''': You're right. It isn't your place.

===Anders and [[Sebastian]]===
ACT II
*'''Anders''': Is that supposed to be Andraste's face on your crotch?
*'''Sebastian''': What?
*'''Anders''': That... belt buckle thing.  Is that Andraste?
*'''Sebastian''': My father had this armor commissioned when I took my vows as a brother.
*'''Anders''': I'm just not sure I'd want the Maker seeing me shove His bride's head between my legs every morning.
{{-}}
*'''Anders''': So, you were invested as a brother in the chantry, right?
*'''Sebastian''': I had just taken my vows when I learned my family was killed.
*'''Anders''': But you... gave sermons and took confessions and such, right?
*'''Sebastian''': Do you have something you wish to confess?
*'''Anders''': I just want to know, what do you say when people have questions?
*'''Anders''': What's your answer when someone asks, \"so if Andraste preached freedom and ended slavery, why do you lock up mages and keep them as slaves?\"
*'''Sebastian''': No one ever asked that.
{{-}}
*'''Sebastian''': You seem very angry.
*'''Anders''': And here I thought the Chantry was against mind-reading.
*'''Sebastian''': Did something happen to you in the Circle?  I understand there were problems in Ferelden...
*'''Anders''': Are you saying a mage can only be unhappy in the Circle if demons were involved?
*'''Anders''': No, it's not about Uldred.  It's not about being beaten or raped by a templar— that does happen, but I've been fortunate.
*'''Anders''': It' s a larger principle: the freedom every man, woman, and child born in Thedas have as a natural right.
*'''Sebastian''': You were given to the Circle.  I was given to the Chantry.  Hawke was driven away from home by the Darkspawn.
*'''Sebastian''': None of us are free.
{{-}}
<small>If you complete [[Dissent]]</small>
*'''Sebastian''': So your \"Tranquil Solution\" was hardly the holocaust you imagined.
*'''Anders''': You've been seeking revenge for the death of one family for as long as I've known you.
*'''Anders''': Are you honestly judging me for trying to save the lives of every mage in Thedas?
*'''Sebastian''': But they were never threatened. It was a single man's lunacy.
*'''Sebastian''': The Chantry would never follow through with such a thing.
*'''Anders''': Yet.
{{-}}
ACT III
*'''Anders''': How can you keep standing up for her?
*'''Sebastian''': Who?
*'''Anders''': That doddering old biddy of a Grand Cleric.
*'''Sebastian''': How dare you! Elthina is everything a grand cleric should be. She's holy, wise—
*'''Anders''': Spineless... hesitant. She's clay in Meredith's hands.
*'''Sebastian''': In the face of danger, sometimes the bravest thing is to stand back and trust that the Maker will see justice done.
*'''Anders''': Well if doing nothing sums up your religion, then Elthina is perfect.  Personally, I'd prefer a Chantry that favors action over sloth.
{{-}}
*'''Sebastian:''' You've made no secret of your intent to lead the mages here in revolution.
*'''Anders:''' Well, I've tried not to shout it from the rooftops. You've just been around when I talk with my friends.
*'''Sebastian:''' Well, as we have mutual friends—who for some reason don't want you to get hurt—let me tell you this:
*'''Sebastian:''' If you go forward with this revolt, the Chantry will bring its full might to bear. They will kill you.
*'''Anders:''' Andraste was killed. That doesn't mean she failed.
*'''Sebastian:''' Do not compare yourself to Andraste.
{{-}}
*'''Anders''': Go ahead. Say it.
*'''Sebastian''': Say what?
*'''Anders''': I saw you watching me.
*'''Sebastian''': I was looking at the clouds.
*'''Anders''': Don't give me that. I know you've been judging me.
*'''Anders''': You think I'm out of control. How can I claim to speak for mages when I'm half demon myself?
*'''Sebastian''': The one over there looks a bit like a bunny rabbit.
<small>If Merrill is in the party:</small>
*'''Merrill''': I saw that too!
{{-}}
*'''Anders''': How can you have so much faith? Does nothing bother you?
*'''Sebastian''': You're bothering me.
*'''Anders''': The Maker left us to our own devices generations ago.
*'''Anders''': He's never going to step back in, start listening to our prayers again. He's gone.
*'''Anders''': Doesn't that bother you?
*'''Sebastian''': He's a merciful lord. He could have destroyed our world when we failed Him, but instead He gave us a chance at redemption.
*'''Sebastian''': Should we not be joyful?

===Anders and [[Varric]]===
ACT I
*'''Anders''': What?
*'''Varric''': Just wondering if the feathered pauldrons are an essential part of the moody rebel mage persona.
*'''Anders''': What are you talking about?
*'''Varric''': I'm working on an epic poem about a hopelessly romantic apostate waging an epic struggle against forces he can't possibly defeat.
*'''Anders''': What do you mean, “can't possibly defeat?”
*'''Varric''': Well, it's not a good story unless the hero dies.
{{-}}
*'''Anders''': I've always wondered, why is every surface dwarf a merchant or a smith?
*'''Varric''': You left out criminals and hired muscle.
*'''Anders''': They don't count.
*'''Varric''': We dwarves are drawn to shiny objects.  Sort of like Magpies, but with business sense.
*'''Anders''': You're kidding.
*'''Varric''': Of course I am.  We come to the surface with the skills our ancestors had, Blondie.
*'''Varric''': You think there's a tradition of dwarf woodcutters in Orzammar?  Bee keepers?  Sailors?
*'''Anders''': Well, there could be mushroom growers and nug wranglers.
*'''Varric''': Orzammar will never let those people go topside.  Too vital.  Also, embarrassing.
{{-}}
*'''Varric''': So a human, an elf, and a dwarf walk into a bar...
*'''Anders''': The human says, \"You're lucky you're so short.  That hurt like mad!\"
*'''Varric''': You could have just stopped me, Blondie.
*'''Anders''': Why waste a perfectly good set-up?
{{-}}
ACT II
*'''Anders''': Boiling in oil.
*'''Varric''': Too prosaic. Trapped in a cave with hungry bears, right at the spring thaw.
*'''Anders''': That lets him off too easy. Dipped in molten gold and left as a statue in the Viscount's Keep.
*'''Varric''': Ooh. That's poetic!
*'''Hawke''': What are you two talking about?
*'''Varric''': What to do to Bartrand when I find him.
*'''Anders''': Any suggestions?
{{-}}
*'''Varric''': Blondie, I don't mean to sound critical, but have you considered a new line of work?
*'''Anders''': Such as?
*'''Varric''': Pretty much anything? I don't think \"renegade mage\" has a bright future. Or any retirement plan.
{{-}}
*'''Varric''': If you've got something to say, just spit it out.
*'''Anders''': Are you sure you want to encourage me? I might be about to confess my undying love.
*'''Varric''': I get that a lot. So what's on your mind?
*'''Anders''': I just realized it's been a while since any of the gangs in the Undercity came to my door.
*'''Varric''': They're busy people. Places to go, throats to cut. Maybe you've slipped their minds.
*'''Anders''': Right. The apostate running the free clinic in the sewers. Easy to forget. You didn't have anything to do with this?
*'''Varric''': You must have me confused with someone else! I'm just a businessman and a storyteller.
{{-}}
<small>If you complete [[Dissent]]</small>
*'''Varric''': Oh, cheer up, Blondie.  You're making me cry just looking at you.
*'''Anders''': Don't.
*'''Varric''': You made a mistake.  It happens.
*'''Anders''': I almost killed a girl.
*'''Varric''': You've killed two-hundred and fifty-four by my last count.  Plus about five hundred men, a few dozen giant spiders, and at least two demons.
*'''Anders''': It's not the same.
*'''Varric''': Why?  Because this one you feel bad about?  Maybe that's the problem.
{{-}}
ACT III
*'''Varric''': So, three templars walk into a tavern.
*'''Anders''': Not right now, Varric.
*'''Varric''': You feeling all right, Blondie? You're always in the mood for templar jokes.
{{-}}
*'''Varric''': So, the knight-commander... Boiling in oil?  That one never gets old.
*'''Anders''': This is past time for joking.
*'''Varric''': I'm helping you indulge in elaborate revenge fantasies.  I think it's good for you.
*'''Anders''': Meredith will die.  Do not doubt that.
*'''Varric''': Go away, Justice.  Can Anders come out and play?
*'''Anders''': Stop.
*'''Varric''': You are no fun anymore.
{{-}}
*'''Varric''': You've been glowering for days. Your face is going to get stuck that way.
*'''Anders''': My face is the least of my concerns right now.
*'''Varric''': That's because you don't have to look at it.
*'''Varric''': If you could see it from this angle, Blondie, it'd be at least a close second on your priority list.
{{-}}
<small>If Hawke romances Anders</small>
*'''Anders''': You're giving me that look again.  What are you writing this time?
*'''Varric''': So, you and Hawke... I need some details.  Did you go down on one knee?  Did he/she jump you?  Did you swear eternal vows of love, or is this just a physical thing?
*'''Anders''': I don't see how that's any of your business.
*'''Varric''': Fine, but if you don't tell me, I'm just going to have to make it up.
{{-}}
LEGACY
''<small>If Hawke romances Anders</small>''
*'''Anders''': More Deep Roads. Why did we agree to do this again?
*'''Varric''': Because I love trouble, and you think Hawke is cute. That wasn't a serious question, was it, Blondie?
*'''Anders''': He/she ''is'' pretty cute.

===Anders and [[Dog]]===
''(if Hawke romances Anders and he moves in)''
*'''Anders''': Now that I'm living here there isn't room for you in the bed.  Do you understand?
*'''Dog''': (Whines)
*'''Anders''': That won't work on me.  I'm a cat person.  Cheer up, old boy.  Maybe you can bunk with Sandal!
*'''Sandal''': Enchantment!
*'''Dog''': (Happy bark!)

in DLC [[Legacy]]

==Anders and [[Carver]] ==
if Carver is templar

*Anders: So, templar. Is the order everything you wished for?

*Anders: Pithed any good mages lately? That's what you do now, right?

*Anders: It must wear on you, given your lineage. No wonder you're quiet.

*Carver: Be grateful. You're free because you know my brother. Don't push it.

*Anders: Oh, yes ser, please ser.


==Anders and [[Varric]] ==

*Anders: Tell me again why I'm down here.
*Varric: Because you think Hawke's cute.
*Anders: ...he is cute...



===Comments===
During [[Night Terrors]], at end of quest after returning from the Fade (may require that Hawke didn't fight him):
*I find there's nothing like being possessed to keep you on the straight and narrow.

<gallery />
<gallery rewfws ewr ew>test gallery</gallery>
<gallery>test gallery</gallery>
<gallery type=\"slideshow\">test slideshow</gallery>
<gallery type=\"slider\">test slider</gallery>
<gallery type=\"slider\" ewrew ew>test slider</gallery>
<gallery type=\"slideshow\" atr=\"wwerew\"></gallery>test slideshow 2</gallery>
<gallery>test gallery 2</gallery>
<input type=tewrw />
";

function microtime_float()
{
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

$script_start = microtime_float();
$before = memory_get_usage() . "\n"; // 36640
$html = str_get_html($text);
echo "find gallery \n";
echo count ( $html->find('gallery') ) . "\n";
$after = memory_get_usage() . "\n"; // 36640

#echo print_r($result, true);
echo "mem usage: " . intval( $after - $before ) . " \n";
$script_end = microtime_float();
echo "Script executed in ".bcsub($script_end, $script_start, 4)." seconds. \n";
exit;


// -----------------------------------------------------------------------------
// nested selector
$str = <<<HTML
<ul id="ul1">
    <li>item:<span>1</span></li>
    <li>item:<span>2</span></li>
</ul>
<ul id="ul2">
    <li>item:<span>3</span></li>
    <li>item:<span>4</span></li>
</ul>
HTML;

$html = str_get_html($str);
foreach($html->find('ul') as $ul) {
    foreach($ul->find('li') as $li)
        echo $li->innertext . '<br>';
}

// -----------------------------------------------------------------------------
// parsing checkbox
$str = <<<HTML
<form name="form1" method="post" action="">
    <input type="checkbox" name="checkbox1" value="checkbox1" checked>item1<br>
    <input type="checkbox" name="checkbox2" value="checkbox2">item2<br>
    <input type="checkbox" name="checkbox3" value="checkbox3" checked>item3<br>
</form>
HTML;

$html = str_get_html($str);
foreach($html->find('input[type=checkbox]') as $checkbox) {
    if ($checkbox->checked)
        echo $checkbox->name . ' is checked<br>';
    else
        echo $checkbox->name . ' is not checked<br>';
}
?>
