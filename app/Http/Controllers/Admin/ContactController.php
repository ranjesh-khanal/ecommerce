<?php

using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;

namespace ContactController
{
    public class ContactController : Controller
    {
        // Simulated data store for contacts
        private static List<Contact> contacts = new List<Contact>
        {
            new Contact { Id = 1, Name = "John Doe", Email = "john@example.com" },
            new Contact { Id = 2, Name = "Jane Smith", Email = "jane@example.com" }
        };

        // GET: Contact
        public IActionResult Index()
        {
            return View(contacts);
        }

        // GET: Contact/Details/5
        public IActionResult Details(int id)
        {
            var contact = contacts.Find(c => c.Id == id);
            if (contact == null)
            {
                return NotFound();
            }
            return View(contact);
        }

        // GET: Contact/Create
        public IActionResult Create()
        {
            return View();
        }

        // POST: Contact/Create
        [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Create(Contact contact)
        {
            if (ModelState.IsValid)
            {
                contacts.Add(contact);
                return RedirectToAction(nameof(Index));
            }
            return View(contact);
        }

        // GET: Contact/Edit/5
        public IActionResult Edit(int id)
        {
            var contact = contacts.Find(c => c.Id == id);
            if (contact == null)
            {
                return NotFound();
            }
            return View(contact);
        }

        // POST: Contact/Edit/5
        [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Edit(int id, Contact contact)
        {
            if (ModelState.IsValid)
            {
                var existingContact = contacts.Find(c => c.Id == id);
                if (existingContact != null)
                {
                    existingContact.Name = contact.Name;
                    existingContact.Email = contact.Email;
                    return RedirectToAction(nameof(Index));
                }
                return NotFound();
            }
            return View(contact);
        }

        // GET: Contact/Delete/5
        public IActionResult Delete(int id)
        {
            var contact = contacts.Find(c => c.Id == id);
            if (contact == null)
            {
                return NotFound();
            }
            return View(contact);
        }

        // POST: Contact/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public IActionResult DeleteConfirmed(int id)
        {
            var contact = contacts.Find(c => c.Id == id);
            if (contact != null)
            {
                contacts.Remove(contact);
                return RedirectToAction(nameof(Index));
            }
            return NotFound();
        }
    }

    public class Contact
    {
        public int Id { get; set; }
        public string Name { get; set; }
        public string Email { get; set; }
    }
}
